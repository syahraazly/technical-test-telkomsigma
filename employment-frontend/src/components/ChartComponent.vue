<template>
  <div>
    <h2>Dashboard</h2>
    <div class="charts-container">
      <div class="chart">
        <h3>Aggregation by Date</h3>
        <canvas id="columnChart"></canvas>
      </div>
      <div class="chart">
        <h3>Count by Category</h3>
        <canvas id="pieChart" height="10"></canvas>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Chart from "chart.js/auto";

export default {
  name: "ChartComponent",
  data() {
    return {
      columnChart: null,
      pieChart: null,
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      try {
        // Mengambil data dari kedua endpoint API
        const [aggregationResponse, categoryResponse] = await Promise.all([
          axios.get("http://localhost:8000/api/employments/aggregation-by-date"),
          axios.get("http://localhost:8000/api/employments/count-by-category"),
        ]);

        // Parsing data untuk column chart
        const aggregationData = aggregationResponse.data || [];
        const columnLabels = aggregationData.map((item) => item.date || "Unknown");
        const columnData = aggregationData.map((item) => item.total || 0);

        // Parsing data untuk pie chart
        const categoryData = categoryResponse.data || [];
        const pieLabels = categoryData.map((item) => item.employment_status || "Unknown");
        const pieData = categoryData.map((item) => item.total || 0);

        // Membuat chart setelah data tersedia
        this.createColumnChart(columnLabels, columnData);
        this.createPieChart(pieLabels, pieData);
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    },
    createColumnChart(labels, data) {
      const ctx = document.getElementById("columnChart").getContext("2d");
      if (this.columnChart) this.columnChart.destroy(); // Hapus chart lama jika ada
      this.columnChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: labels,
          datasets: [
            {
              label: "Total by Date",
              data: data,
              backgroundColor: "rgba(54, 162, 235, 0.2)",
              borderColor: "rgba(54, 162, 235, 1)",
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
            },
          },
        },
      });
    },
    createPieChart(labels, data) {
      const ctx = document.getElementById("pieChart").getContext("2d");
      if (this.pieChart) this.pieChart.destroy(); // Hapus chart lama jika ada
      this.pieChart = new Chart(ctx, {
        type: "pie",
        data: {
          labels: labels,
          datasets: [
            {
              data: data,
              backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF"],
              hoverOffset: 4,
            },
          ],
        },
        options: {
          responsive: true,
        },
      });
    },
  },
};
</script>

<style>
.charts-container {
  display: flex;
  /* Aktifkan flexbox */
  justify-content: space-around;
  /* Beri jarak antar chart */
  flex-wrap: wrap;
  /* Pastikan elemen tidak meluap ke luar layar */
}

.chart {
  flex: 1;
  /* Membagi ruang yang tersedia secara proporsional */
  /* max-width: 45%; */
  /* Atur ukuran maksimal agar tidak terlalu besar */
  text-align: center;
  /* Pusatkan teks di setiap chart */
  margin: 10px;
  /* Tambahkan margin untuk spasi */
}

canvas {
  max-width: 100%;
  /* Pastikan canvas tidak meluap */
  height: auto;
  /* Jaga aspek rasio canvas */
}
</style>


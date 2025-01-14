<template>
  <div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-xl font-semibold text-gray-700 mb-4">Aggregation by Date</h2>

      <!-- filter Tanggal -->
      <div class="flex justify-between items-center mb-4">
        <div>
          <label for="startDate" class="mr-2">Start Date:</label>
          <input id="startDate" type="date" v-model="localStartDate" class="border rounded p-2" />
        </div>
        <div>
          <label for="endDate" class="mr-2">End Date:</label>
          <input id="endDate" type="date" v-model="localEndDate" class="border rounded p-2" />
        </div>
        <button @click="applyFilters" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          Apply Filters
        </button>
      </div>

      <!-- column chart -->
      <div>
        <canvas ref="columnChart" class=" min-h-96"></canvas>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Chart from "chart.js/auto";

export default {
  data() {
    return {
      localStartDate: "",
      localEndDate: "",
      chart: null, 
    };
  },
  methods: {
    async fetchChartData(params = {}) {
      try {
        const response = await axios.get(
          "http://localhost:8000/api/employments/aggregation-by-date",
          { params }
        );

        const data = response.data || [];
        const labels = data.map((item) => item.date || "Unknown");
        const values = data.map((item) => item.total || 0);

        // validasi apakah elemen canvas tersedia
        if (!this.$refs.columnChart) {
          console.error("Canvas element is not ready");
          return;
        }

        const ctx = this.$refs.columnChart.getContext("2d");

        // hapus chart sebelumnya jika sudah ada
        if (this.chart) {
          this.chart.destroy();
        }

        // create chart baru
        this.chart = new Chart(ctx, {
          type: "bar",
          data: {
            labels,
            datasets: [
              {
                label: "Total Employees",
                data: values,
                backgroundColor: "rgba(54, 162, 235, 0.6)",
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              x: {
                beginAtZero: true,
              },
              y: {
                beginAtZero: true,
                ticks: {
                  // tampilkan tanpa desimal
                  callback: function (value) {
                    return Number.isInteger(value) ? value : '';
                  },
                },
              },
            },
            plugins: {
              tooltip: {
                callbacks: {
                  // format tooltip untuk tidak menampilkan desimal
                  label: function (context) {
                    return `${context.dataset.label}: ${Math.round(context.raw)}`;
                  },
                },
              },
            },
          },
        });
      } catch (error) {
        console.error("Failed to fetch Column Chart data:", error);
      }
    },
    applyFilters() {
      const params = {};
      if (this.localStartDate) params.start_date = this.localStartDate;
      if (this.localEndDate) params.end_date = this.localEndDate;

      // fetch new data and update the chart
      this.fetchChartData(params);
    },
  },
  mounted() {
    this.$nextTick(() => {
      this.fetchChartData(); // load data setelah elemen siap
    });
  },
};
</script>

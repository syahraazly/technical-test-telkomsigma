<script setup>
import "mosha-vue-toastify/dist/style.css";
import { createToast } from "mosha-vue-toastify";
</script>

<template>
  <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Employment Data</h1>

    <!-- form -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
      <h2 class="text-xl font-semibold text-gray-700 mb-4">{{ action === 'update' ? 'Edit Employment Data' : 'Add Employment Data' }}</h2>
      <form class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div class="flex items-start space-x-4">
          <label for="name" class="w-1/3 text-gray-700 font-medium mb-1 text-left">Name <span
              class="text-red-500">*</span></label>
          <input id="name" type="text" v-model="name" placeholder="Enter name"
            class="w-2/3 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
        </div>

        <div class="flex items-center space-x-4">
          <label class="w-1/3 text-gray-700 font-medium mb-1 text-left">Gender <span
              class="text-red-500">*</span></label>
          <div class="w-2/3 flex items-center space-x-4">
            <label class="flex items-center space-x-2">
              <input id="male" type="radio" value="Male" v-model="gender" class="text-blue-600" />
              <span>Male</span>
            </label>
            <label class="flex items-center space-x-2">
              <input id="female" type="radio" value="Female" v-model="gender" class="text-blue-600" />
              <span>Female</span>
            </label>
          </div>
        </div>

        <div class="flex items-center space-x-4">
          <label for="role" class="w-1/3 text-gray-700 font-medium mb-1 text-left">Role <span
              class="text-red-500">*</span></label>
          <input id="role" type="text" v-model="role" placeholder="Enter role"
            class="w-2/3 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
        </div>

        <div class="flex items-center space-x-4">
          <label class="w-1/3 text-gray-700 font-medium mb-1 text-left">Job Grade <span
              class="text-red-500">*</span></label>
          <div class="w-2/3 flex items-center space-x-4">
            <label class="flex items-center space-x-2">
              <input id="junior" type="radio" value="Junior" v-model="job_grade" class="text-blue-600" />
              <span>Junior</span>
            </label>
            <label class="flex items-center space-x-2">
              <input id="middle" type="radio" value="Middle" v-model="job_grade" class="text-blue-600" />
              <span>Middle</span>
            </label>
            <label class="flex items-center space-x-2">
              <input id="senior" type="radio" value="Senior" v-model="job_grade" class="text-blue-600" />
              <span>Senior</span>
            </label>
          </div>
        </div>

        <div class="flex items-center space-x-4">
          <label for="employment_no" class="w-1/3 text-gray-700 font-medium mb-1 text-left">Employment No <span
              class="text-red-500">*</span></label>
          <input id="employment_no" type="text" v-model="employment_no" placeholder="Enter employment number"
            class="w-2/3 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
        </div>

        <div class="flex items-center space-x-4">
          <label class="w-1/3 text-gray-700 font-medium mb-1 text-left">Employment Status <span
              class="text-red-500">*</span></label>
          <div class="w-2/3 flex items-center space-x-4">
            <label class="flex items-center space-x-2">
              <input id="probation" type="radio" value="Probation" v-model="employment_status" class="text-blue-600" />
              <span>Probation</span>
            </label>
            <label class="flex items-center space-x-2">
              <input id="permanent" type="radio" value="Permanent" v-model="employment_status" class="text-blue-600" />
              <span>Permanent</span>
            </label>
            <label class="flex items-center space-x-2">
              <input id="contract" type="radio" value="Contract" v-model="employment_status" class="text-blue-600" />
              <span>Contract</span>
            </label>
          </div>
        </div>

        <div class="flex items-center space-x-4">
          <label for="manager" class="w-1/3 text-gray-700 font-medium mb-1 text-left">Manager <span
              class="text-red-500">*</span></label>
          <input id="manager" type="text" v-model="manager" placeholder="Enter manager name"
            class="w-2/3 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
        </div>

        <div class="flex items-center space-x-4">
          <label for="join_date" class="w-1/3 text-gray-700 font-medium mb-1 text-left">Join Date <span
              class="text-red-500">*</span></label>
          <input id="join_date" type="date" v-model="join_date"
            class="w-2/3 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
        </div>

        <div class="flex items-center space-x-4">
          <label for="end_date" class="w-1/3 text-gray-700 font-medium mb-1 text-left">End Date</label>
          <input id="end_date" type="date" v-model="end_date"
            class="w-2/3 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
        </div>

        <div class="md:col-span-2 flex justify-end space-x-4 mt-4">
          <button type="button" @click="saveData"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Save</button>
          <button type="button" @click="addData"
            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Clear</button>
        </div>
      </form>
    </div>

    <!-- table -->
    <div class=" bg-white shadow-md rounded-lg p-6">
      <h2 class="text-xl font-semibold text-gray-700 mb-4">Employment List</h2>

      <!-- filtering -->
      <div class="flex mb-4">
        <!-- filter by search (input text) -->
        <input type="text" v-model="search" placeholder="Search..." class="border border-gray-300 p-2 rounded mr-4" />

        <!-- filter by employment status (select category) -->
        <select v-model="employmentStatus" class="border border-gray-300 p-2 rounded ml-4">
          <option value="">All Status</option>
          <option value="contract">Contract</option>
          <option value="probation">Probation</option>
          <option value="permanent">Permanent</option>
        </select>
        
        <button @click="applyFilters" class="bg-blue-500 text-white px-4 py-2 ml-8 rounded hover:bg-blue-600">Search</button>
      </div>
  
      <table class="min-w-full bg-white border border-gray-200 rounded-lg">
        <thead>
          <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <th class="py-3 px-6 text-left">Employment No</th>
            <th class="py-3 px-6 text-left">Name</th>
            <th class="py-3 px-6 text-left">Gender</th>
            <th class="py-3 px-6 text-left">Role</th>
            <th class="py-3 px-6 text-left">Job Grade</th>
            <th class="py-3 px-6 text-left">Employment Status</th>
            <th class="py-3 px-6 text-left">Manager</th>
            <th class="py-3 px-6 text-left">Join Date</th>
            <th class="py-3 px-6 text-left">End Date</th>
            <th class="py-3 px-6 text-center">Actions</th>
          </tr>
        </thead>
        <tbody class="text-gray-700 text-sm">
          <tr v-for="item in paginatedData" :key="item.employment_no"
            class="border-b border-gray-200 hover:bg-gray-100">
            <td class="py-3 px-6">{{ item.employment_no }}</td>
            <td class="py-3 px-6">{{ item.name }}</td>
            <td class="py-3 px-6">{{ item.gender }}</td>
            <td class="py-3 px-6">{{ item.role }}</td>
            <td class="py-3 px-6">{{ item.job_grade }}</td>
            <td class="py-3 px-6">{{ item.employment_status }}</td>
            <td class="py-3 px-6">{{ item.manager }}</td>
            <td class="py-3 px-6">{{ item.join_date }}</td>
            <td class="py-3 px-6">{{ item.end_date }}</td>
            <td class="py-3 px-6 text-center">
              <button @click="editData(item)"
                class="bg-yellow-400 text-white px-3 py-1 rounded-lg hover:bg-yellow-500 mx-1"><img
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAA70lEQVR4nO2UPQ4BURRGWYSfPRGlRqO0AGRkJBRYgn2gZgUqjFgHDfFz5MUnRswwY6YgfN17yT3n3XuTl0j8XIA0MOOWNmADa6AcN7wF1FznE1B5F54BFgLNgRTQ4DHH0J1wgTsCGEla9328swkDzwJLFTqSmbEUgKSPxA4K7wE7FS0Ft3Te+UiaYV6/UdFWnVzh+EgageESdCXpeMDvJKHAHiKL56lHgVdfwIMt9A//mJlbghyAoQfcigLPuuAl3Q1igQuWF2iscxHYRx6LS2D+dpMVMFEn0V/uEox4jB0LXIKpFms6yZmdxAb/6pwBH4vIPNFtRDAAAAAASUVORK5CYII="
                  alt="ball-point-pen--v1"></button>
              <button @click="deleteData(item.id)"
                class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 mx-1"><img
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABO0lEQVR4nLXVMUsDQRCG4SuCQoRoo42WijZaxV6x1c4mjYEg/gFRBBut4i+wtxAhtZ2goHW0sQkxdipqr4WEVxa+4pAkN7cTBxaOvZ152Bt2L0kyAjijd/wAm4k3gAfgEzhJjVMhR8MCrv7MjbkBoAQsAx2gBRykdnAo4AIoh7XWoiPAHnAPdPt8+17RVc4uMDoI2MIftUFA7b+BInAMPEUUbiu3aO3HFLAGVIF9oJ5qcl29qmrNpKmoCs8Bs+YERcgJuUlWABVt+RW4DWcAuAQawLlGQ3Ph3R3wppyKBdhwNHjdAqw6gBULEE5vbJQtwIIDmLcAMw5g2gJMOIBxC1BwAIVMQMh3RPEvU3EBHxHAex7gOQLo5AGaEUAzD7AT8UfbNgNClnQ13wCPwEtopEZ4DnPXuroX+xX6Bf348YY97O7MAAAAAElFTkSuQmCC"
                  alt="delete"></button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- pagination -->
      <div class="flex justify-between items-center mt-4">
        <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1"
          class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50">
          Previous
        </button>

        <div>
          <button v-for="page in totalPages" :key="page" @click="changePage(page)" :class="{
            'px-4 py-2 mx-1 rounded': true,
            'bg-blue-500 text-white': page === currentPage,
            'bg-gray-200 hover:bg-gray-300': page !== currentPage,
          }">
            {{ page }}
          </button>
        </div>

        <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages"
          class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50">
          Next
        </button>
      </div>
    </div>

  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "EmploymentManagement",
  data: function () {
    return {
      list_employment: [],
      id: 0,
      name: '',
      gender: '',
      role: '',
      job_grade: '',
      employment_no: '',
      employment_status: '',
      manager: '',
      join_date: '',
      end_date: '',
      action: '',
      currentPage: 1,
      itemsPerPage: 10,
      search: '',
      employmentStatus: '',
      filteredData: [],
    }
  },
  computed: {
    paginatedData() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.list_employment.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.list_employment.length / this.itemsPerPage);
    },
  },
  methods: {
    // get data dari API
    async fetchData() {
      try {
        const resp = await axios.get("/employments");
        this.list_employment = resp.data;
        this.filteredData = [...this.list_employment]; 
      } catch (error) {
        console.error("Error in fetchData:", error);
        this.createAlert("Failed to fetch data", "error");
        return [];
      }
    },

    // pagination
    changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
      } else {
        this.currentPage = 1; // reset ke halaman pertama
      }
    },

    // reset form
    resetForm() {
      this.id = "";
      this.name = "";
      this.gender = "";
      this.role = "";
      this.job_grade = "";
      this.employment_no = "";
      this.employment_status = "";
      this.manager = "";
      this.join_date = "";
      this.end_date = "";
      this.action = ""; 
    },

    // tambah data
    addData() {
      this.id = "";
      this.name = "";
      this.gender = "";
      this.role = "";
      this.job_grade = "";
      this.employment_no = "";
      this.employment_status = "";
      this.manager = "";
      this.join_date = "";
      this.end_date = "";
      this.action = "insert";
    },

    // edit data
    editData(item) {
      this.id = item.id;
      this.name = item.name;
      this.gender = item.gender;
      this.role = item.role;
      this.job_grade = item.job_grade;
      this.employment_no = item.employment_no;
      this.employment_status = item.employment_status;
      this.manager = item.manager;
      this.join_date = item.join_date;
      this.end_date = item.end_date;
      this.action = "update";
    },

    //  simpan data yang telah di edit/add
    async saveData() {
      let form = {
        // id: this.id,
        name: this.name,
        gender: this.gender,
        role: this.role,
        job_grade: this.job_grade,
        employment_no: this.employment_no,
        employment_status: this.employment_status,
        manager: this.manager,
        join_date: this.join_date,
        end_date: this.end_date,
      };

      try {
        if (this.action === "insert") {
          const resp = await axios.post("/employments", form);
          console.log("resp post", resp);
          this.createAlert("Data inserted successfully", "success");
        } else {
          const resp = await axios.put(`/employments/${this.id}`, form);
          console.log("resp put", resp);

          this.createAlert("Data updated successfully", "success");
        }
        this.resetForm();
        await this.fetchData(); 
      } catch (error) {
        console.error("Error in saveData:", error);
        this.createAlert("Failed to save data", "warning");
      }
    },

    // hapus data
    async deleteData(id) {
      if (confirm("Are you sure delete this data?")) {
        try {
          const resp = await axios.delete(`/employments/${id}`);
          console.log("resp delete", resp);
          this.createAlert("Data deleted successfully", "success");
          await this.fetchData(); 
        } catch (error) {
          console.error("Error in deleteData:", error);
          this.createAlert("Failed to delete data", "error");
        }
      }
    },

    // filter dan pencarian
    async applyFilters() {
      if (!this.search && !this.employmentStatus) {
        await this.fetchData(); // reset ke semua data jika tidak ada filter
        return;
      }

      try {
        const response = await axios.get('/employments', {
          params: {
            search: this.search || undefined,
            employment_status: this.employmentStatus || undefined,
          },
        });

        this.list_employment = response.data; // update data asli
        this.filteredData = [...this.list_employment]; // perbarui data tabel
      } catch (error) {
        console.error('Error fetching filtered data:', error);
        this.createAlert('Failed to fetch filtered data', 'error');
      }
    },

    // alert
    createAlert(message, type) {
      createToast(message, {
        position: "top-right",
        type: type,
        timeout: 1500,
        dismissible: true,
        pauseOnFocusLoss: true,
        pauseOnHover: true,
        closeOnClick: true,
        closeButton: true,
        icon: true,
        rtl: false,
      });
    },
  },
  mounted() {
    this.fetchData();
  }
}
</script>

<style>

</style>

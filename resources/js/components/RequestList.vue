<template>
    <div class="p-6 max-w-4xl mx-auto bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-bold mb-4">Daftar Permintaan Barang</h2>

        <table class="w-full border-collapse border border-gray-300 rounded-lg shadow-md">
    <thead>
        <tr class="bg-blue-500 text-white text-lg">
            <th class="border border-gray-300 p-4">#</th>
            <th class="border border-gray-300 p-4">Nama</th>
            <th class="border border-gray-300 p-4">Departemen</th>
            <th class="border border-gray-300 p-4">Status</th>
            <th class="border border-gray-300 p-4">Aksi</th>
        </tr>
    </thead>
    <tbody class="bg-white">
        <tr v-for="(request, index) in requests" :key="request.id" class="hover:bg-gray-100 transition">
            <td class="border border-gray-300 p-4">{{ index + 1 }}</td>
            <td class="border border-gray-300 p-4">{{ request.user.name }}</td>
            <td class="border border-gray-300 p-4">{{ request.user.department }}</td>
            <td class="border border-gray-300 p-4">
                <select v-model="request.status" @change="updateStatus(request.id, request.status)" class="p-2 border rounded-lg bg-gray-100 focus:ring focus:ring-blue-300">
                    <option value="Pending">Pending</option>
                    <option value="Fulfilled">Fulfilled</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </td>
            <td class="border border-gray-300 p-4">
                <button @click="toggleDetails(request.id)" class="text-blue-500 hover:underline">Lihat</button>
            </td>
        </tr>
    </tbody>
</table>


        <div v-if="selectedRequest" class="mt-4 p-4 border rounded bg-gray-100">
            <h3 class="text-lg font-bold">Detail Permintaan</h3>
            <p><strong>Nama:</strong> {{ selectedRequest.user.name }}</p>
            <p><strong>Departemen:</strong> {{ selectedRequest.user.department }}</p>
            <p><strong>Status:</strong> {{ selectedRequest.status }}</p>
            <h4 class="mt-2 font-semibold">Barang:</h4>
            <ul>
                <li v-for="item in selectedRequest.request_items" :key="item.id">
                    {{ item.item.name }} - {{ item.quantity_requested }} {{ item.item.unit }} (Terpenuhi: {{ item.quantity_fulfilled }})
                </li>
            </ul>
            <button @click="selectedRequest = null" class="mt-2 text-red-500">Tutup</button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const requests = ref([]);
const selectedRequest = ref(null);

onMounted(async () => {
    try {
        const response = await axios.get('/api/requests');
        requests.value = response.data;
    } catch (error) {
        console.error("Gagal mengambil data permintaan:", error);
    }
});

const toggleDetails = async (id) => {
    selectedRequest.value = requests.value.find(req => req.id === id);
};

const updateStatus = async (id, newStatus) => {
    try {
        await axios.put(`/api/requests/${id}/update-status`, { status: newStatus });
        alert("Status berhasil diperbarui!");
    } catch (error) {
        console.error(error);
        alert("Gagal memperbarui status!");
    }
};
</script>

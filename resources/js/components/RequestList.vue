<template>
    <div class="p-6 max-w-4xl mx-auto bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-bold mb-4">Daftar Permintaan Barang</h2>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 p-2">#</th>
                    <th class="border border-gray-300 p-2">Nama Karyawan</th>
                    <th class="border border-gray-300 p-2">Departemen</th>
                    <th class="border border-gray-300 p-2">Status</th>
                    <th class="border border-gray-300 p-2">Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(request, index) in requests" :key="request.id">
                    <td class="border border-gray-300 p-2">{{ index + 1 }}</td>
                    <td class="border border-gray-300 p-2">{{ request.user.name }}</td>
                    <td class="border border-gray-300 p-2">{{ request.user.department }}</td>
                    <td class="border border-gray-300 p-2">
                        <span :class="getStatusClass(request.status)">{{ request.status }}</span>
                    </td>
                    <td class="border border-gray-300 p-2">
                        <button @click="toggleDetails(request.id)" class="text-blue-500">Lihat</button>
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
    const response = await axios.get('/api/requests');
    requests.value = response.data;
});

const toggleDetails = async (id) => {
    selectedRequest.value = requests.value.find(req => req.id === id);
};

const getStatusClass = (status) => {
    return {
        'text-green-600 font-semibold': status === 'Fulfilled',
        'text-yellow-600 font-semibold': status === 'Partially Fulfilled',
        'text-red-600 font-semibold': status === 'Rejected',
        'text-gray-600 font-semibold': status === 'Pending',
    };
};
</script>

<style scoped>
button {
    cursor: pointer;
}
</style>

<template>
    <div class="p-6 max-w-2xl mx-auto bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-bold mb-4">Form Permintaan Barang</h2>

        <form @submit.prevent="submitRequest">
            <!-- Input NIK -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Masukkan NIK:</label>
                <input
                    v-model="nik"
                    @input="fetchUserByNik"
                    type="text"
                    class="w-full p-2 border rounded"
                    placeholder="Masukkan NIK"
                />
            </div>

            <!-- Auto-Fill Nama & Departemen -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Nama:</label>
                <input type="text" v-model="form.user_name" class="w-full p-2 border rounded bg-gray-200" disabled />
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Departemen:</label>
                <input type="text" v-model="form.department" class="w-full p-2 border rounded bg-gray-200" disabled />
            </div>

            <!-- Pilihan Barang -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Pilih Barang:</label>
                <div v-for="(item, index) in form.items" :key="index" class="flex gap-2 mb-2">
                    <select v-model="item.item_id" class="w-3/4 p-2 border rounded">
                        <option v-for="barang in items" :key="barang.id" :value="barang.id">
                            {{ barang.name }} (Stok: {{ barang.stock }})
                        </option>
                    </select>
                    <input type="number" v-model="item.quantity" min="1" class="w-1/4 p-2 border rounded" placeholder="Qty">
                    <button @click.prevent="removeItem(index)" class="text-red-500">X</button>
                </div>
                <button @click.prevent="addItem" class="text-blue-500">+ Tambah Barang</button>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Kirim Permintaan</button>
        </form>

        <p v-if="message" class="mt-4 text-green-500">{{ message }}</p>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const users = ref([]);
const items = ref([]);
const message = ref('');
const nik = ref('');
const form = ref({
    user_id: '',
    user_name: '',
    department: '',
    items: [{ item_id: '', quantity: 1 }]
});

onMounted(async () => {
    const itemsResponse = await axios.get('/api/items');
    items.value = itemsResponse.data;
});

// Fetch user by NIK
const fetchUserByNik = async () => {
    if (nik.value.length >= 5) {
        try {
            const response = await axios.get(`/api/users/nik/${nik.value}`);
            form.value.user_id = response.data.id;
            form.value.user_name = response.data.name;
            form.value.department = response.data.department;
        } catch (error) {
            form.value.user_id = '';
            form.value.user_name = 'User tidak ditemukan';
            form.value.department = '';
        }
    }
};

const addItem = () => {
    form.value.items.push({ item_id: '', quantity: 1 });
};

const removeItem = (index) => {
    form.value.items.splice(index, 1);
};

const submitRequest = async () => {
    try {
        const response = await axios.post('/api/requests', form.value);
        message.value = response.data.message;
        form.value = { user_id: '', user_name: '', department: '', items: [{ item_id: '', quantity: 1 }] };
        nik.value = '';
    } catch (error) {
        console.error(error);
        message.value = "Terjadi kesalahan!";
    }
};
</script>

<style scoped>
button {
    cursor: pointer;
}
</style>

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
                    required
                />
            </div>

            <!-- Auto-Fill Nama & Departemen -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Nama:</label>
                <input type="text" v-model="form.user_name" class="w-full p-2 border rounded bg-gray-200" disabled required />
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Departemen:</label>
                <input type="text" v-model="form.department" class="w-full p-2 border rounded bg-gray-200" disabled required />
            </div>

            <!-- Pilihan Barang -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Pilih Barang:</label>
                <div v-for="(item, index) in form.items" :key="index" class="mb-4 p-4 border rounded bg-gray-100">
                    <select v-model="item.item_id" @change="updateItemDetails(index)" class="w-full p-2 border rounded" required>
                        <option value="" disabled>Pilih Barang</option>
                        <option v-for="barang in items" :key="barang.id" :value="barang.id">
                            {{ barang.name }} (Stok: {{ barang.stock }} {{ barang.unit }})
                        </option>
                    </select>

                    <!-- Detail Barang -->
                    <div v-if="item.details" class="mt-2 text-sm text-gray-700">
                        <p><strong>Lokasi:</strong> {{ item.details.location }}</p>
                        <p><strong>Stok:</strong> {{ item.details.stock }} {{ item.details.unit }}</p>
                        <p><strong>Satuan:</strong> {{ item.details.unit }}</p>
                    </div>

                    <!-- Input Kuantitas Permintaan -->
                    <input type="number" v-model="item.quantity" min="1" class="w-full p-2 border rounded mt-2" placeholder="Kuantitas" @input="checkStock(index)" required>

                    <!-- Alert jika stok kurang -->
                    <p v-if="item.stock_status === 'Kosong'" class="text-red-500 mt-2">Barang tidak tersedia!</p>
                    <p v-if="item.stock_status === 'Sebagian'" class="text-yellow-500 mt-2">Stok tidak mencukupi, harap kurangi jumlah!</p>
                    <p v-if="item.stock_status === 'Melebihi Stok'" class="text-red-500 mt-2 font-bold">Jumlah melebihi stok! Harap kurangi.</p>

                    <button @click.prevent="removeItem(index)" class="text-red-500 mt-2">Hapus</button>
                </div>
                <button @click.prevent="addItem" class="text-blue-500">+ Tambah Barang</button>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded" :disabled="!isFormValid">Kirim Permintaan</button>
        </form>

        <p v-if="message" class="mt-4 text-green-500">{{ message }}</p>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const nik = ref('');
const form = ref({
    user_id: '',
    user_name: '',
    department: '',
    items: [{ item_id: '', quantity: 1, details: null, stock_status: '' }]
});
const message = ref('');
const items = ref([]);

// Fetch daftar barang saat komponen dimuat
onMounted(async () => {
    const response = await axios.get('/api/items');
    items.value = response.data;
});

// Fetch user berdasarkan NIK
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

// Update detail barang saat barang dipilih
const updateItemDetails = (index) => {
    const selectedItem = items.value.find(i => i.id === form.value.items[index].item_id);
    if (selectedItem) {
        form.value.items[index].details = {
            location: selectedItem.location,
            stock: selectedItem.stock,
            unit: selectedItem.unit
        };
        checkStock(index);
    }
};

// Cek status stok berdasarkan jumlah permintaan
const checkStock = (index) => {
    const item = form.value.items[index];
    if (!item.details) return;

    const stock = item.details.stock;
    const quantity = item.quantity;

    if (quantity > stock) {
        item.stock_status = 'Melebihi Stok';
        alert(`Jumlah permintaan (${quantity} ${item.details.unit}) melebihi stok tersedia (${stock} ${item.details.unit})!`);
    } else if (quantity === stock) {
        item.stock_status = 'Sebagian';
    } else {
        item.stock_status = 'Tersedia';
    }
};

// Validasi sebelum submit
const isFormValid = computed(() => {
    return form.value.items.every(item => item.item_id && item.quantity > 0 && item.stock_status !== 'Melebihi Stok' && item.stock_status !== 'Kosong');
});

// Tambah & Hapus Barang
const addItem = () => {
    form.value.items.push({ item_id: '', quantity: 1, details: null, stock_status: '' });
};
const removeItem = (index) => {
    form.value.items.splice(index, 1);
};

// Kirim permintaan ke backend
const submitRequest = async () => {
    if (!isFormValid.value) {
        alert("Form tidak valid. Pastikan semua field diisi dan stok mencukupi.");
        return;
    }
    try {
        const response = await axios.post('/api/requests', form.value);
        alert("Permintaan berhasil dikirim!");
        message.value = response.data.message;
        form.value = { user_id: '', user_name: '', department: '', items: [{ item_id: '', quantity: 1, details: null, stock_status: '' }] };
        nik.value = '';
    } catch (error) {
        console.error(error);
        alert("Terjadi kesalahan saat mengirim permintaan!");
    }
};
</script>

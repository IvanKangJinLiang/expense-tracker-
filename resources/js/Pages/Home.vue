<template>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-extrabold text-gray-900">
                    Expense Tracker
                </h1>
                <p class="mt-2 text-sm text-gray-600">
                    Manage your daily expenses. 
                </p>
            </div>

            <div
                v-if="successMessage"
                class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm transition-all duration-500"
            >
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ successMessage }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-10 border border-gray-100">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ isEditing ? 'Edit Expense' : 'Add New Expense' }}
                    </h2>
                    <span v-if="isEditing" class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded">
                        Editing Mode
                    </span>
                </div>

                <form @submit.prevent="submitExpense" class="p-6 space-y-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <input
                                v-model="form.description"
                                type="text"
                                placeholder="e.g. Chicken Rice"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out sm:text-sm border p-2"
                                :class="{ 'border-red-500 ring-red-500': errors.description }"
                            />
                            <p v-if="errors.description" class="mt-1 text-sm text-red-600">
                                {{ errors.description[0] }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                            <div class="relative rounded-md shadow-sm">
                                <input
                                    v-model="form.amount"
                                    type="number"
                                    step="0.01"
                                    placeholder="0.00"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
                                    :class="{ 'border-red-500': errors.amount }"
                                />
                            </div>
                            <p v-if="errors.amount" class="mt-1 text-sm text-red-600">
                                {{ errors.amount[0] }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                            <select
                                v-model="form.currency"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
                            >
                                <option value="MYR">MYR - Malaysian Ringgit</option>
                                <option value="USD">USD - US Dollar</option>
                                <option value="EUR">EUR - Euro</option>
                            </select>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input
                                v-model="form.expense_date"
                                type="date"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
                                :class="{ 'border-red-500': errors.expense_date }"
                            />
                            <p v-if="errors.expense_date" class="mt-1 text-sm text-red-600">
                                {{ errors.expense_date[0] }}
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 gap-3">
                        <button 
                            v-if="isEditing"
                            type="button" 
                            @click="cancelEdit"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 text-sm font-medium transition-colors"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            :disabled="isLoading"
                            class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                            :class="isEditing ? 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500' : 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500'"
                        >
                            <svg v-if="isLoading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ isLoading ? "Processing..." : (isEditing ? "Update Expense" : "Submit") }}
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">Recent Expenses</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Total: {{ expenses.length }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="expense in expenses" :key="expense.id" class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ expense.description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span :class="{
                                        'text-green-600 font-semibold': expense.currency === 'MYR',
                                        'text-blue-600 font-semibold': expense.currency === 'USD',
                                    }">
                                        {{ formatAmount(expense.amount, expense.currency) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ formatDate(expense.expense_date) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button 
                                        @click="editExpense(expense)" 
                                        class="text-indigo-600 hover:text-indigo-900 mr-4 font-semibold"
                                    >
                                        Edit
                                    </button>
                                    <button 
                                        @click="deleteExpense(expense.id)" 
                                        class="text-red-600 hover:text-red-900 font-semibold"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            <tr v-if="expenses.length === 0">
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-10 w-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <p>No expenses recorded yet.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

// State Variables
const expenses = ref([]);
const errors = ref({});
const isLoading = ref(false);
const successMessage = ref("");

// Edit Mode State
const isEditing = ref(false);
const editingId = ref(null);

const form = ref({
    description: "",
    amount: "",
    currency: "MYR",
    expense_date: "",
});

// --- API ACTIONS ---
const fetchExpenses = async () => {
    try {
        const res = await axios.get("/expenses");
        expenses.value = res.data;
    } catch (e) {
        console.error("Failed to load list", e);
    }
};

const submitExpense = async () => {
    // Reset states
    errors.value = {};
    successMessage.value = "";
    isLoading.value = true;

    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");
        if (token) {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = token;
        }

        if (isEditing.value) {
            await axios.put(`/expenses/${editingId.value}`, form.value);
            successMessage.value = "Expense updated successfully!";
        } else {
            await axios.post("/expenses", form.value);
            successMessage.value = "Expense saved successfully!";
        }

        await fetchExpenses();
        cancelEdit(); 

        // Hide success message after 3 seconds
        setTimeout(() => (successMessage.value = ""), 3000);

    } catch (error) {
        console.error("Error submitting expense:", error);
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        } else {
            alert("An unexpected error occurred. Please try again.");
        }
    } finally {
        isLoading.value = false;
    }
};

const deleteExpense = async (id) => {
    if (!confirm("Are you sure you want to delete this expense?")) return;

    try {
        await axios.delete(`/expenses/${id}`);

        await fetchExpenses();
        successMessage.value = "Expense deleted successfully!";
        setTimeout(() => (successMessage.value = ""), 3000);
        
        if (isEditing.value && editingId.value === id) {
            cancelEdit();
        }
    } catch (error) {
        console.error("Failed to delete", error);
        alert("Could not delete expense.");
    }
};

const editExpense = (expense) => {
    form.value = {
        description: expense.description,
        amount: expense.amount,
        currency: expense.currency,
        expense_date: expense.expense_date, 
    };

    isEditing.value = true;
    editingId.value = expense.id;
    errors.value = {};

    window.scrollTo({ top: 0, behavior: 'smooth' });
};

const cancelEdit = () => {
    form.value = {
        description: "",
        amount: "",
        currency: "MYR",
        expense_date: "",
    };
    isEditing.value = false;
    editingId.value = null;
    errors.value = {};
};

const formatAmount = (amount, currency) => {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: currency,
    }).format(amount);
};

const formatDate = (date) => {
    if (!date) return "-";
    return new Date(date).toLocaleDateString(undefined, {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
};

onMounted(() => {
    fetchExpenses();
});
</script>
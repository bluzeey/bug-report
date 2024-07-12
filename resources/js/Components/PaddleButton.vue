<script setup>

import {onMounted, ref} from "vue";
import axios from "axios";

const props = defineProps({
    priceId: String
})
const checkout = ref({
    items: [],
    custom: {},
    return_url: ''
})

const openCheckout = () => {
    window.Paddle.Checkout.open({
        items: checkout.value.items,
        custom: checkout.value.custom,
        return_url: checkout.value.return_url,
    });
}

onMounted(() => {
    axios.get('/paddle/checkout/' + props.priceId)
        .then(response => {
            checkout.value = response.data
        })
        .catch(error => {
            alert('Error fetching checkout data')
        })
});
</script>

<template>
    <p
        class="text-white bg-indigo-700 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white dark:focus:ring-primary-900 w-full"
        @click.prevent='openCheckout'>
        Buy Product
    </p>
</template>

<style scoped>

</style>

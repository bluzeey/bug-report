<script setup>
import { defineProps } from 'vue';
import Pricing from "@/Components/Pricing.vue";

const props = defineProps({
    productId: String,
    proPriceId: String,
    proPlusPriceId: String
});
</script>

<template>
    <Pricing
        :product-id="props.productId"
        :pro-price-id="props.proPriceId"
        :pro-plus-price-id="props.proPlusPriceId"
    />
</template>

<style scoped>
</style>

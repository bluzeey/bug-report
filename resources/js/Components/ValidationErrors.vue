<template>
    <div v-if="hasErrors">
        <div class="font-medium text-red-600">Whoops! Something went wrong.</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        errors: Object
    },
    computed: {
        hasErrors() {
            return this.errors ? Object.keys(this.errors).length > 0 : false;
        },
    }
}
</script>

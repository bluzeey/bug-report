<template>
    <button
        :class="varietyClasses + ' ' + sizeClasses + (loading ? ' opacity-25' : '')"
        :disabled="loading"
        :type="type"
        class="inline align-center text-center border rounded-md font-semibold capitalize focus:outline-none focus:ring disabled:opacity-25 transition"
    >
        <span class="relative">
            <span :class="{ invisible: loading }"><slot/></span>
            <span class="absolute inset-0">
                <svg
                    v-show="loading"
                    class="mx-auto h-full animate-spin text-white"
                    fill="none"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    />
                    <path
                        class="opacity-75"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        fill="currentColor"
                    />
                </svg>
            </span>
        </span>
    </button>
</template>

<script>
import {defineComponent} from 'vue';

export default defineComponent({
    props: {
        type: {
            type: String,
            default: 'submit',
        },
        variety: {
            type: String,
            default: 'default',
        },
        size: {
            type: String,
            default: 'md',
        },
        loading: {
            type: Boolean,
            default: false,
        },
    },

    computed: {
        sizeClasses() {
            switch (this.size) {
                case 'xs':
                    return 'px-2 py-0.5 text-xs';
                case 'sm':
                    return 'px-3 py-1 text-sm';
                case 'md':
                    return 'px-4 py-2 text-base';
                case 'lg':
                    return 'px-4 py-2 text-lg';
                case 'xl':
                    return 'px-5 py-3 text-xl';
                default:
                    return 'text-base';
            }
        },
        varietyClasses() {
            switch (this.variety) {
                case 'primary':
                    return 'border-transparent bg-amber-500 text-white hover:bg-orange-600 active:bg-orange-800 focus:border-orange-700 focus:ring-orange-300';
                case 'danger':
                    return 'border-transparent bg-red-500 text-white hover:bg-red-700 active:bg-red-900 focus:border-red-900 focus:ring-red-300';
                case 'success':
                    return 'border-transparent bg-green-500 text-white hover:bg-green-700 active:bg-green-900 focus:border-green-900 focus:ring-green-300';
                case 'secondary':
                    return 'bg-white text-black border-gray-300 hover:bg-gray-300 active:bg-gray-500 focus:border-gray-700 focus:ring-gray-200';
                default:
                    return 'border-transparent bg-gray-800 text-white hover:bg-gray-700 active:bg-gray-900 focus:border-gray-900 focus:ring-gray-300';
            }
        },
    },
});
</script>

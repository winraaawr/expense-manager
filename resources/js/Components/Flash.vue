<template>
    <div
        class="px-2 py-1 text-emerald-600 text-sm border-l-4 border-emerald-600"
    >
        {{ $page.props.flash.message }}
    </div>
</template>

<script setup>
import { onUpdated } from "vue";
import { ref, onMounted } from "vue";

const showFlash = ref(true);

function closeFlash() {
    showFlash.value = false;
}

</script>

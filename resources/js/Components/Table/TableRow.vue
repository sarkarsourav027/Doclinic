<script setup>

import {useTableRowClasses} from "@/Composables/useTableRowClasses.js";

const {tableRowClasses} = useTableRowClasses()
</script>

<template>
    <tr :class="tableRowClasses">
        <slot></slot>
    </tr>
</template>

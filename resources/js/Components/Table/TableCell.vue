<script setup>

import {useTableCellClasses} from "@/Composables/useTableCellClasses.js";

const {tableCellClasses} = useTableCellClasses()
</script>

<template>
    <td :class="tableCellClasses">
        <slot></slot>
    </td>
</template>

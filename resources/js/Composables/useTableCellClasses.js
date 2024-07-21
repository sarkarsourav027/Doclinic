import { computed, inject } from 'vue'
import classNames from 'classnames'

const baseClasses = 'px-6 py-2 text-gray-500 text-sm'

export function useTableCellClasses() {

    const tableCellClasses = computed(() => {
        return classNames(baseClasses)
    })

    return {
        tableCellClasses,
    }
}

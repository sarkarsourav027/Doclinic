import {computed, inject} from 'vue'
import classNames from 'classnames'

const baseClasses = 'bg-white dark:bg-gray-800 border dark:border-gray-700'

export function useTableRowClasses() {
    const tableRowClasses = computed(() => {
        return classNames(baseClasses)
    })

    return {
        tableRowClasses,
    }
}

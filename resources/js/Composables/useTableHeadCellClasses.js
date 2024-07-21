import {computed, inject} from 'vue'
import classNames from 'classnames'

const baseClasses = 'px-6 py-4'
const stripedHeadCellClasses = ''
export function useTableHeadCellClasses() {
    const isColumnsStriped = inject('stripedColumns')

    const tableHeadCellClasses = computed(() => {
        return classNames(baseClasses, {
            [stripedHeadCellClasses]: isColumnsStriped,
        })
    })

    return {
        tableHeadCellClasses,
    }
}

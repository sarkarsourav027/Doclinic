import {
    RaDashboard,
    IoOutlineFlask,
    CaStethoscope,
    LiWheelchair, BsPlusSquare,
} from "@/utils/icons.js";
import {reactive} from "vue";

// Create the reactive array with the correct type
const navigation = reactive([
    {
        route: "dashboard",
        label: "Dashboard",
        component: 'dashboard',
        icon: RaDashboard,
        isOpen: false
    },
    {
        route: "test.index",
        label: "Test",
        component: 'test',
        icon: IoOutlineFlask,
        isOpen: false
    },
    {
        route: "doctor.index",
        label: "Doctor",
        component: 'doctor',
        icon: CaStethoscope,
        isOpen: false
    },
    {
        route: "patient.index",
        label: "Patient",
        component: 'patient',
        icon: LiWheelchair,
        isOpen: false
    },
    {
        route: "appointment.index",
        label: "Appointment",
        component: 'appointment',
        icon: BsPlusSquare,
        isOpen: false
    },
    /*{
        route: "#",
        label: "Partner",
        component: '',
        icon: CaPartnership,
        permission: 'can-view-partner|can-view-pre-billing',
        isOpen: false,
        children: [
            {
                route: "ikk-partner.index",
                label: "Partner",
                component: 'ikk-partner',
                icon: ByUser,
                permission: 'can-view-partner',
                isOpen: false
            },
            {
                route: "pre-billing.index",
                label: "Pre Billing",
                component: 'pre-billing',
                icon: FlClockBill,
                permission: 'can-view-pre-billing',
                isOpen: false
            },
        ]
    },*/
]);

export default navigation;

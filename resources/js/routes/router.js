import {
    RaDashboard,
    IoOutlineFlask,
    CaStethoscope,
    LiWheelchair,
    BsPlusSquare,
    CdAccount,
    AkCreditCard
} from "@/utils/icons.js";
import {reactive} from "vue";

// Create the reactive array with the correct type
const navigation = reactive([
    {
        route: "dashboard.index",
        label: "Dashboard",
        component: 'dashboard',
        icon: RaDashboard,
        isOpen: false
    },
    {
        route: "clinical-test.index",
        label: "Clinical Test",
        component: 'clinical-test',
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
    {
        route: "billing.index",
        label: "Billing",
        component: 'billing',
        icon: AkCreditCard,
        isOpen: false
    },
    {
        route: "account.index",
        label: "Accounts",
        component: 'account',
        icon: CdAccount,
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

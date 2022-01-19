import Vue from "vue";
import VueRouter from "vue-router";

// Register Vue Router
Vue.use(VueRouter);

// Project
const ProjectMainComponent = () =>
    import ("../components/project/ProjectMainComponent.vue");
const ProjectIndex = () =>
    import ("../components/project/ProjectHome.vue");
const ProjectDetails = () =>
    import ("../components/project/ProjectDetail.vue");
const ProjectViewDocument = () =>
    import ("../components/project/partials/ProjectDocumentView.vue");
// Heavy Equipment
const HeavyEquipmentMainComponent = () =>
    import ("../components/heavy_equipment/HeavyEquipmentMainComponent.vue");
const HeavyEquipmentIndex = () =>
    import ("../components/heavy_equipment/HeavyEquipmentIndex.vue");
const HeavyEquipmentDetails = () =>
    import ("../components/heavy_equipment/HeavyEquipmentDetails.vue");

// truc vehicle
const TruckVehicleMainComponent = () =>
    import ("../components/vehicle/TruckVehicleMainComponent.vue");
const TruckVehicleIndex = () =>
    import ("../components/vehicle/TruckVehicleIndex.vue");
const TruckVehicleDetails = () =>
    import ("../components/vehicle/TruckVehicleDetails.vue");

// Other Inventory
const OtherInventoryMainComponent = () =>
    import ("../components/other_inventory/OtherInventoryMainComponent.vue");
const OtherInventoryIndex = () =>
    import ("../components/other_inventory/OtherInventoryIndex.vue");
const OtherInventoryDetails = () =>
    import ("../components/other_inventory/OtherInventoryDetails.vue");

// FIxed Assets
const FixedAssetMainComponent = () =>
    import ("../components/fixed_assets/FixedAssetMainComponent.vue");
const FixedAssetIndex = () =>
    import ("../components/fixed_assets/FixedAssetIndex.vue");

// Category Inventory
const CategoryInventoryMainComponent = () =>
    import ("../components/categories_inventory/CategoryInventoryMianComponent.vue");
const CategoryInventoryIndex = () =>
    import ("../components/categories_inventory/CategoryInventoryIndex.vue");

// Type Inventory
const TypeInventoryMainComponent = () =>
    import ("../components/types_inventory/TypeInventoryMainComponent.vue");
const TypeInventoryIndex = () =>
    import ("../components/types_inventory/TypeInventoryIndex.vue");

// consumable inventory
const ConsumableMainComponent = () =>
    import ("../components/consumable_inventory/ConsumableMainComponent.vue");
const ConsumableIndex = () =>
    import ('../components/consumable_inventory/ConsumableIndex.vue');

// Supplier Management
const SupplierManagementMainComponent = () =>
    import ('../components/supplier_management/SupplierManagementMainComponent.vue')
const SupplierManagementIndex = () =>
    import ('../components/supplier_management/SupplierManagementIndex.vue');
const SupplierDetails = () =>
    import ("../components/supplier_management/partials/SupplierDetails.vue")

// Request Material
const RequestMaterialMainComponent = () =>
    import ('../components/material/RequestMaterialMainComponent.vue');
const RequestMaterialIndex = () =>
    import ('../components/material/RequestMaterialIndex.vue');
const RequestMaterialDetails = () =>
    import ('../components/material/RequestMaterialDetails.vue');

// Not Found
const NotFound = () =>
    import ("../components/global/NotFound.vue");

export default new VueRouter({
    linkActiveClass: "active",
    linkExactActiveClass: "",
    scrollBehavior() {
        return { x: 0, y: 0 };
    },
    routes: [{
            path: "/project-main",
            name: "Project Main Component",
            props: true,
            component: ProjectMainComponent,
            children: [{
                    path: '/project-list',
                    name: "Project List",
                    props: true,
                    component: ProjectIndex
                },
                {
                    path: '/project-list/:id',
                    name: "Project Details",
                    props: true,
                    component: ProjectDetails
                },
                {
                    path: '/view-file',
                    name: 'View Document',
                    props: true,
                    component: ProjectViewDocument
                }
            ]
        },

        // Assets Inventory Routes

        {
            path: "/heavyEquipment",
            name: 'Heavy Equipment Component',
            component: HeavyEquipmentMainComponent,
            children: [{
                    path: '/list',
                    name: 'Heavy Equipment',
                    props: true,
                    component: HeavyEquipmentIndex
                },
                {
                    path: '/hDetails/:id',
                    name: 'Heavy Equipment Details',
                    props: true,
                    component: HeavyEquipmentDetails
                }
            ]
        },
        {
            path: "/truckVehicle",
            name: 'Truck Vehicle Main Component',
            component: TruckVehicleMainComponent,
            children: [{
                    path: '/list-truck-vehicle',
                    name: 'Truck Vehicle List',
                    component: TruckVehicleIndex,
                    props: true
                },
                {
                    path: '/list-truck-vehicle/:id',
                    name: 'Truck Vehicle Details',
                    component: TruckVehicleDetails,
                    props: true
                }
            ]
        },
        {
            path: '/OtherMainComponent',
            name: 'Other Main Component',
            component: OtherInventoryMainComponent,
            props: true,
            children: [{
                    path: '/other-inventory',
                    name: 'Other Inventory Index',
                    props: true,
                    component: OtherInventoryIndex
                },
                {
                    path: '/other-inventory/:id',
                    name: 'Other Inventory Details',
                    props: true,
                    component: OtherInventoryDetails
                }
            ]
        },
        {
            path: "/FixedAssetMainComponent",
            name: "Fixed Asset Main Component",
            component: FixedAssetMainComponent,
            props: true,
            children: [{
                path: "/fixed-asset-list",
                name: "Fixed Asset List",
                component: FixedAssetIndex,
                props: true
            }]
        },
        {
            path: '/CategoryInventoryMainComponent',
            name: 'Category Inventory Main Component',
            props: true,
            component: CategoryInventoryMainComponent,
            children: [{
                path: '/category-inventory-list',
                name: 'Category Inventory Index',
                props: true,
                component: CategoryInventoryIndex
            }]
        },
        {
            path: '/TypeInventoryMainComponent',
            name: 'Type Inventory Main Component',
            props: true,
            component: TypeInventoryMainComponent,
            children: [{
                path: '/type-inventory-list',
                name: 'Type Inventory Index',
                props: true,
                component: TypeInventoryIndex
            }]
        },
        {
            path: '/ConsumableMainComponent',
            name: 'Consumable Main Component',
            props: true,
            component: ConsumableMainComponent,
            children: [{
                path: '/consumable-inventory',
                name: 'Consumable Inventory List',
                props: true,
                component: ConsumableIndex
            }]
        },

        // End Assets Inventory Routes
        // Purchase
        {
            path: '/SupplierManagementMainComponent',
            name: 'Supplier Management Main Component',
            props: true,
            component: SupplierManagementMainComponent,
            children: [{
                    path: '/supplier-management',
                    name: 'Supplier Management',
                    component: SupplierManagementIndex,
                    props: true
                },
                {
                    path: '/supplier-details/:id',
                    name: 'Supplier Management Details',
                    component: SupplierDetails,
                    props: true
                }
            ]
        },

        {
            path: '/PurchaseOrderMainComponent',
            nam: 'Purchase Order Main Component',
            props: true,
            component: () => import ('../components/purchase_order/PurchaseOrderMainComponent.vue'),
            children: [
                {
                    path: '/purchase-order',
                    name: 'Purchase Order Index',
                    props: true,
                    component: () => import ('../components/purchase_order/PurchaseOrderIndex.vue')
                },
                {
                    path: '/purchase-order/:id',
                    name: 'Purchase Order View',
                    props: true,
                    component: () => import ('../components/purchase_order/PurchaseOrderView.vue')
                },
                {
                    path: '/purchase-order-details/:id',
                    name: 'Purchase Order Details',
                    props: true,
                    component: () => import ('../components/purchase_order/PurchaseOrderDetails.vue')
                }
            ]
        },

        // Request Material
        {
            path: '/RequestMaterialMainComponent',
            name: 'Request Materail Main Component',
            component: RequestMaterialMainComponent,
            props: true,
            children: [{
                    path: '/request-material',
                    name: 'Request Material Index',
                    props: true,
                    component: RequestMaterialIndex
                },
                {
                    path: '/request-material/:id',
                    name: 'Request Material Details',
                    props: true,
                    component: RequestMaterialDetails
                }
            ]
        },

        // consumable supply

        {
            path: '/ConsumableSupplyMainComponent',
            name: 'Consumable Supply Main Component',
            props: true,
            component: () => import ('../components/consumable_supply/ConsumableSupplyMainComponent.vue'),
            children: [
                {
                    path: '/consumable-supply',
                    name: 'Consumable Supply List',
                    props: true,
                    component: () => import ('../components/consumable_supply/ConsumableSupplyIndex.vue')
                }
            ]
        },

        // purchase

        {
            path: '/PurchaseRecieveMainComponent',
            name: 'Purchase Recieve Main Component',
            props: true,
            component: () => import ('../components/purchase_recieve/PurchaseRecieveMainComponent.vue'),
            children: [
                {
                    path: '/purchase-recieved',
                    name: 'Purchase Recieved Index',
                    props: true,
                    component: () => import ('../components/purchase_recieve/PurchaseRecieveIndex.vue')
                },
                {
                    path: '/purchase-received-view/:id',
                    name: 'Purchase Received View',
                    props: true,
                    component: () => import ('../components/purchase_recieve/PurchaseReceiveView.vue')
                }
            ]
        },

        // stock out

        {
            path: '/FixedAssetStockOutMainComponent',
            name: 'Fixed Asset Stock Out Main Component',
            props: true,
            component: () => import ('../components/asset_stock_out/FixedAssetStockOutMainComponent.vue'),
            children: [
                {
                    path: '/fixed-asset-stock-out',
                    name: 'Fixed Asset Stock Out Index',
                    props: true,
                    component: () => import ('../components/asset_stock_out/FixedAssetStockOutIndex.vue'),
                }
            ]
        },
        {
            path: '/ConsumableItemStockOutMainComponent',
            name: 'Consumable Item Stock Out Main Component',
            props: true,
            component: () => import ('../components/consumable_item_stock_out/ConsumableItemStockOutMainComponent.vue'),
            children: [
                {
                    path: '/consumable-item-stock-out',
                    name: 'Consumable Item Stock Out Index',
                    props: true,
                    component: () => import ('../components/consumable_item_stock_out/ConsumableItemStockOutIndex.vue')
                }
            ]
        },
        {
            path: '/setting',
            name: 'Setting',
            props: true,
            component: () => import('../components/setting/GeneralSettingMainComponent.vue'),
            children: [
                {
                    path: '/job-order-type',
                    name: 'Job Order Type',
                    props: true,
                    component: () => import('../components/setting/job_order_type/JobOrderType.vue'),
                },
                {
                    path: '/maintenance-type',
                    name: 'Maintenance Type',
                    props: true,
                    component: () => import('../components/setting/maintenance_type/MaintenanceType.vue'),
                },
                {
                    path: '/project-status',
                    name: 'Project Status',
                    props: true,
                    component: () => import('../components/setting/project_status/ProjectStatus.vue'),
                }
            ]
        },

        {
            path: '/customer',
            name: 'Customer',
            component: () => import('../components/customer/CustomerMainComponent.vue'),
            props: true,
            children: [
                {
                    path: '/customers',
                    name: 'Customers',
                    component: () => import('../components/customer/CustomerIndex.vue'),
                    props: true,
                },
                {
                    path: '/cview/:id',
                    name: 'View Customer',
                    component: () => import('../components/customer/partials/CustomerView.vue'),
                    props: true,
                }
            ]
        },

        {
            path: '/proposal',
            name: 'Proposal',
            props: true,
            component: () => import('../components/proposal/ProposalMainComponent.vue'),
            children: [
                {
                    path: '/proposals',
                    name: 'Proposals',
                    props: true,
                    component: () => import('../components/proposal/ProposalIndex.vue'),
                },
                {
                    path: '/pcreate/:id',
                    name: 'Update Proposal',
                    props: true,
                    component: () => import('../components/proposal/form/ProposalForm.vue'),
                },
                {
                    path: '/pcreate',
                    name: 'Create Proposal',
                    props: true,
                    component: () => import('../components/proposal/form/ProposalForm.vue'),
                },
                {
                    path: '/pview/:id',
                    name: 'Proposal View',
                    props: true,
                    component: () => import('../components/proposal/partials/ProposalView.vue'),
                }
            ]
        },
        {
            path: '/invoice',
            name: 'Invoice',
            component: () => import('../components/invoice/InvoiceMainComponent.vue'),
            props: true,
            children: [
                {
                    path: '/invoices',
                    name: 'Invoices',
                    props: true,
                    component: () => import('../components/invoice/InvoiceIndex.vue')
                },
                {
                    path: '/icreate/:id',
                    name: 'Update Invoice',
                    props: true,
                    component: () => import('../components/invoice/form/InvoiceForm.vue')
                },

                {
                    path: '/icreate',
                    name: 'Create Invoice',
                    props: true,
                    component: () => import('../components/invoice/form/InvoiceForm.vue')
                },
                {
                    path: '/iview/:id',
                    name: 'Invoice View',
                    props: true,
                    component: () => import('../components/invoice/partials/InvoiceView.vue')
                },
                {
                    path: '/download/:id',
                    name: 'Invoice Download',
                    props: true,
                    component: () => import('../components/invoice/partials/InvoiceDownload.vue')
                }
            ]
        },
        {
            path: '/bank',
            name: 'Bank Main Component',
            props: true,
            component: () => import('../components/bank/BankMainComponent.vue'),
            children: [
                {
                    path: '/accounts',
                    name: 'Bank Accounts',
                    props: true,
                    component: () => import('../components/bank/BankAccountIndex.vue')
                },
                {
                    path: '/transfers',
                    name: 'Bank Transfer',
                    props: true,
                    component: () => import('../components/bank/BankTransferIndex.vue')
                }
            ]
        },
        {
            path: '/revenue',
            name: 'Revenue Main Component',
            props: true,
            component: () => import('../components/revenue/RevenueMainComponent.vue'),
            children: [
                {
                    path: '/revenues',
                    name: 'Revenue',
                    props: true,
                    component: () => import('../components/revenue/RevenueIndex.vue')
                }
            ]
        },
        {
            path: '/bill',
            name: 'Bill Main Component',
            props: true,
            component: () => import('../components/bill/BillMainComponent.vue'),
            children: [
                {
                    path: '/bills',
                    name: 'Bill List',
                    component: () => import('../components/bill/BillIndex.vue'),
                    props: true,
                },
                {
                    path: '/bill-create/:id',
                    name: 'Bill Update',
                    component: () => import('../components/bill/form/BillForm.vue'),
                    props: true,
                },
                {
                    path: '/bill-create/',
                    name: 'Bill Create',
                    component: () => import('../components/bill/form/BillForm.vue')
                },
                {
                    path: '/bview/:id',
                    name: 'Bill View',
                    component: () => import('../components/bill/partials/BillView.vue'),
                    props: true,
                },
                {
                    path: '/bviewc/:id',
                    name: 'Bill View 2',
                    component: () => import('../components/bill/partials/BillView2.vue'),
                    props: true,
                },
                {
                    path: '/bill-createc/',
                    name: 'Bill Create 2',
                    component: () => import('../components/bill/form/BillForm2.vue'),
                    props: true
                },
                {
                    path: '/bill-createc/:id',
                    name: 'Bill Update 2',
                    component: () => import('../components/bill/form/BillForm2.vue'),
                    props: true
                }
            ]
        },

        {
            path: '/debit-note',
            name: 'Debit Note Main Component',
            props: true,
            component: () => import('../components/debit_note/DebitNoteMainComponent.vue'),
            children: [
                {
                    path: '/debit-notes',
                    name: 'Debit Note List',
                    props: true,
                    component: () => import('../components/debit_note/DebitNoteIndex.vue')
                }
            ]
        },
        {
            path: '/payment',
            name: 'Payment Main Component',
            component: () => import('../components/payment/PaymentMainComponent.vue'),
            props: true,
            children: [
                {
                    path: '/payment-list',
                    name: 'Payment List',
                    component: () => import('../components/payment/PaymentIndex.vue'),
                    props: true,
                }
            ]
        },

        // Not Found
        {
            path: "*",
            name: 'Not Found',
            component: NotFound
        }
    ]
});

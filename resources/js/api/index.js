import Project from './project/project';

// fixed assets inventory
import HeavyEquipment from './heavy_equipment/heavy_equipment';
import HeavyEquipmentJobOrder from './heavy_equipment/heavy_equipment_job_order'
import HeavyEquipmentMaintenance from './heavy_equipment/heavy_equipment_maintenance'
import TruckVehicle from './truck_vehicle/truck_vehicle';
import TruckVehicleJobOrder from './truck_vehicle/truck_vehicle_job_order'
import TruckVehicleMaintenance from './truck_vehicle/truck_vehicle_maintenance'
import OtherInventory from './other_inventory/other_inventory';
import OtherJobOrder from './other_inventory/other_job_oder'
import OtherMaintenance from './other_inventory/other_maintenance';
import FixedAsset from './fixed_asset/fixed_asset';
import CategoryInventory from './category_inventory/category_inventory';
import TypeInventory from './type_inventory/type_inventory';

// purchase
import SupplierManagement from './supplier_management/supplier_management';
import Consumable from './supplier_management/consumable';
import PurchaseOrder from './purchase_order/purchase_order';
import PurchaseReceived from './purchase_recieved/purchase_recieved';
// Request Material
import RequestMaterial from './request_material/request_material';

// StockOut
import FixedAssetStockOut from './fixed_asset_stock_out/fixed_asset_stock_out'
import ConsumableStockOut from './consumable_stock_out/consumable_stock_out'

// General Setting
import JobOrderType from './setting/job_order_type'
import MaintenanceType from './setting/maintenance_type'
import ProjectStatus from './setting/project_status'
import BillOfMaterial from './setting/bill_of_material'

//Accounting
import Service from './service/service'
import Customer from './customer/customer'
import Proposal from './proposal/proposal'
import Invoice from './invoice/invoice'
import InvoicePayment from './invoice/invoice_payment'
import Constant from './constant/constant'
import CreditNote from './credit_note/credit_note'
import Bank from './bank/bank'
import Revenue from './revenue/revenue'
import Bill from './bill/bill'
import BillPayment from './bill/bill_payments'
import DebitNote from './bill/debit_note'
import Payment from './payment/payment'
import Attachment from './attachment/attachment'

export default {
    // project
    Project,

    // fixed assets
    HeavyEquipment,
    HeavyEquipmentJobOrder,
    HeavyEquipmentMaintenance,
    TruckVehicle,
    TruckVehicleJobOrder,
    TruckVehicleMaintenance,
    OtherInventory,
    OtherJobOrder,
    OtherMaintenance,
    FixedAsset,
    CategoryInventory,
    TypeInventory,

    // purchase
    SupplierManagement,
    Consumable,
    PurchaseOrder,
    PurchaseReceived,

    // Request Material
    RequestMaterial,

    // Stock Out
    FixedAssetStockOut,
    ConsumableStockOut,
    // setting
    JobOrderType,
    MaintenanceType,
    ProjectStatus,
    BillOfMaterial,

    // accounting
    Service,
    Customer,
    Proposal,
    Invoice,
    InvoicePayment,
    Constant,
    CreditNote,
    Bank,
    Revenue,
    Bill,
    BillPayment,
    DebitNote,
    Payment,
    Attachment
}

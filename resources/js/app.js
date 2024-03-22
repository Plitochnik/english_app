import './bootstrap';
import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import Lara from '@/presets/lara';

// prime vue styles
import 'primevue/resources/themes/aura-light-blue/theme.css';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';

// prime vue components
import PrimeVue from 'primevue/config';
import AutoComplete from 'primevue/autocomplete';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import AnimateOnScroll from 'primevue/animateonscroll';
import Avatar from 'primevue/avatar';
import AvatarGroup from 'primevue/avatargroup';
import Badge from 'primevue/badge';
import BadgeDirective from "primevue/badgedirective";
import BlockUI from 'primevue/blockui';
import Button from 'primevue/button';
import ButtonGroup from 'primevue/buttongroup';
import Breadcrumb from 'primevue/breadcrumb';
import Calendar from 'primevue/calendar';
import Card from 'primevue/card';
import CascadeSelect from 'primevue/cascadeselect';
import Carousel from 'primevue/carousel';
import Checkbox from 'primevue/checkbox';
import Chip from 'primevue/chip';
import Chips from 'primevue/chips';
import ColorPicker from 'primevue/colorpicker';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import ConfirmDialog from 'primevue/confirmdialog';
import ConfirmPopup from 'primevue/confirmpopup';
import ConfirmationService from 'primevue/confirmationservice';
import ContextMenu from 'primevue/contextmenu';
import DataTable from 'primevue/datatable';
import DataView from 'primevue/dataview';
import DataViewLayoutOptions from 'primevue/dataviewlayoutoptions';
import DeferredContent from 'primevue/deferredcontent';
import Dialog from 'primevue/dialog';
import DialogService from 'primevue/dialogservice'
import Divider from 'primevue/divider';
import Dock from 'primevue/dock';
import Dropdown from 'primevue/dropdown';
import DynamicDialog from 'primevue/dynamicdialog';
import Fieldset from 'primevue/fieldset';
import FileUpload from 'primevue/fileupload';
import FloatLabel from 'primevue/floatlabel';
import FocusTrap from 'primevue/focustrap';
import Galleria from 'primevue/galleria';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import Image from 'primevue/image';
import InlineMessage from 'primevue/inlinemessage';
import Inplace from 'primevue/inplace';
import InputGroup from 'primevue/inputgroup';
import InputGroupAddon from 'primevue/inputgroupaddon';
import InputMask from 'primevue/inputmask';
import InputNumber from 'primevue/inputnumber';
import InputOtp from 'primevue/inputotp';
import InputSwitch from 'primevue/inputswitch';
import InputText from 'primevue/inputtext';
import Knob from 'primevue/knob';
import Listbox from 'primevue/listbox';
import MegaMenu from 'primevue/megamenu';
import Menu from 'primevue/menu';
import Menubar from 'primevue/menubar';
import Message from 'primevue/message';
import MeterGroup from 'primevue/metergroup';
import MultiSelect from 'primevue/multiselect';
import OrderList from 'primevue/orderlist';
import OrganizationChart from 'primevue/organizationchart';
import OverlayPanel from 'primevue/overlaypanel';
import Paginator from 'primevue/paginator';
import Panel from 'primevue/panel';
import PanelMenu from 'primevue/panelmenu';
import Password from 'primevue/password';
import PickList from 'primevue/picklist';
import ProgressBar from 'primevue/progressbar';
import ProgressSpinner from 'primevue/progressspinner';
import Rating from 'primevue/rating';
import RadioButton from 'primevue/radiobutton';
import Ripple from 'primevue/ripple';
import Row from 'primevue/row';
import SelectButton from 'primevue/selectbutton';
import ScrollPanel from 'primevue/scrollpanel';
import ScrollTop from 'primevue/scrolltop';
import Skeleton from 'primevue/skeleton';
import Slider from 'primevue/slider';
import Sidebar from 'primevue/sidebar';
import SpeedDial from 'primevue/speeddial';
import SplitButton from 'primevue/splitbutton';
import Splitter from 'primevue/splitter';
import SplitterPanel from 'primevue/splitterpanel';
import Stepper from 'primevue/stepper';
import StepperPanel from 'primevue/stepperpanel';
import Steps from 'primevue/steps';
import StyleClass from 'primevue/styleclass';
import TabMenu from 'primevue/tabmenu';
import TieredMenu from 'primevue/tieredmenu';
import Textarea from 'primevue/textarea';
import ToastService from 'primevue/toastservice';
import Toolbar from 'primevue/toolbar';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import Tag from 'primevue/tag';
import Terminal from 'primevue/terminal';
import Timeline from 'primevue/timeline';
import ToggleButton from 'primevue/togglebutton';
import Tooltip from 'primevue/tooltip';
import Tree from 'primevue/tree';
import TreeSelect from 'primevue/treeselect';
import TreeTable from 'primevue/treetable';
import TriStateCheckbox from 'primevue/tristatecheckbox';
import VirtualScroller from 'primevue/virtualscroller';


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin}) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Toast)
            .use(PrimeVue, {
                // unstyled: true,
                // pt: Lara
            })
            .directive('tooltip', Tooltip)
            .directive('badge', BadgeDirective)
            .directive('ripple', Ripple)
            .directive('styleclass', StyleClass)
            .directive('focustrap', FocusTrap)
            .directive('animateonscroll', AnimateOnScroll)
            .component('Accordion', Accordion)
            .component('AccordionTab', AccordionTab)
            .component('AutoComplete', AutoComplete)
            .component('Avatar', Avatar)
            .component('AvatarGroup', AvatarGroup)
            .component('Badge', Badge)
            .component('BlockUI', BlockUI)
            .component('Breadcrumb', Breadcrumb)
            .component('Button', Button)
            .component('ButtonGroup', ButtonGroup)
            .component('Calendar', Calendar)
            .component('Card', Card)
            .component('Carousel', Carousel)
            .component('CascadeSelect', CascadeSelect)
            .component('Checkbox', Checkbox)
            .component('Chip', Chip)
            .component('Chips', Chips)
            .component('ColorPicker', ColorPicker)
            .component('Column', Column)
            .component('ColumnGroup', ColumnGroup)
            .component('ConfirmDialog', ConfirmDialog)
            .component('ConfirmPopup', ConfirmPopup)
            .component('ContextMenu', ContextMenu)
            .component('DataTable', DataTable)
            .component('DataView', DataView)
            .component('DataViewLayoutOptions', DataViewLayoutOptions)
            .component('DeferredContent', DeferredContent)
            .component('Dialog', Dialog)
            .component('Divider', Divider)
            .component('Dock', Dock)
            .component('Dropdown', Dropdown)
            .component('DynamicDialog', DynamicDialog)
            .component('Fieldset', Fieldset)
            .component('FileUpload', FileUpload)
            .component('FloatLabel', FloatLabel)
            .component('Galleria', Galleria)
            .component('IconField', IconField)
            .component('Image', Image)
            .component('InlineMessage', InlineMessage)
            .component('Inplace', Inplace)
            .component('InputGroup', InputGroup)
            .component('InputGroupAddon', InputGroupAddon)
            .component('InputIcon', InputIcon)
            .component('InputMask', InputMask)
            .component('InputNumber', InputNumber)
            .component('InputOtp', InputOtp)
            .component('InputSwitch', InputSwitch)
            .component('InputText', InputText)
            .component('Knob', Knob)
            .component('Listbox', Listbox)
            .component('MegaMenu', MegaMenu)
            .component('Menu', Menu)
            .component('Menubar', Menubar)
            .component('Message', Message)
            .component('MeterGroup', MeterGroup)
            .component('MultiSelect', MultiSelect)
            .component('OrderList', OrderList)
            .component('OrganizationChart', OrganizationChart)
            .component('OverlayPanel', OverlayPanel)
            .component('Paginator', Paginator)
            .component('Panel', Panel)
            .component('PanelMenu', PanelMenu)
            .component('Password', Password)
            .component('PickList', PickList)
            .component('ProgressBar', ProgressBar)
            .component('ProgressSpinner', ProgressSpinner)
            .component('RadioButton', RadioButton)
            .component('Rating', Rating)
            .component('Row', Row)
            .component('SelectButton', SelectButton)
            .component('ScrollPanel', ScrollPanel)
            .component('ScrollTop', ScrollTop)
            .component('Slider', Slider)
            .component('Sidebar', Sidebar)
            .component('Skeleton', Skeleton)
            .component('SpeedDial', SpeedDial)
            .component('SplitButton', SplitButton)
            .component('Splitter', Splitter)
            .component('SplitterPanel', SplitterPanel)
            .component('Stepper', Stepper)
            .component('StepperPanel', StepperPanel)
            .component('Steps', Steps)
            .component('TabMenu', TabMenu)
            .component('TabView', TabView)
            .component('TabPanel', TabPanel)
            .component('Tag', Tag)
            .component('Textarea', Textarea)
            .component('Terminal', Terminal)
            .component('TieredMenu', TieredMenu)
            .component('Timeline', Timeline)
            .component('Toolbar', Toolbar)
            .component('ToggleButton', ToggleButton)
            .component('Tree', Tree)
            .component('TreeSelect', TreeSelect)
            .component('TreeTable', TreeTable)
            .component('TriStateCheckbox', TriStateCheckbox)
            .component('VirtualScroller', VirtualScroller)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });

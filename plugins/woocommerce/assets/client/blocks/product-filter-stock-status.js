(()=>{var e,t,o,r={9477:(e,t,o)=>{"use strict";o.r(t);var r=o(1609);const l=window.wp.blocks;var n=o(7104),c=o(885);const s=window.wc.wcSettings;o(1832);var a=o(6087),i=o(851);const u=window.wp.blockEditor,p=window.wp.components;var m=o(7723);const d=window.wc.blocksComponents;o(5400);const w=({name:e,count:t})=>(0,r.createElement)(r.Fragment,null,e,null!==t&&Number.isFinite(t)&&(0,r.createElement)(d.Label,{label:t.toString(),screenReaderLabel:(0,m.sprintf)(/* translators: %s number of products. */ /* translators: %s number of products. */
(0,m._n)("%s product","%s products",t,"woocommerce"),t),wrapperElement:"span",wrapperProps:{className:"wc-filter-element-label-list-count"}}));var y=o(4717);const _=window.wc.wcTypes;var b=o(5574),f=o(923),g=o.n(f);function v(e){const t=(0,a.useRef)(e);return g()(e,t.current)||(t.current=e),t.current}const E=window.wc.wcBlocksData,h=window.wp.data,k=(0,a.createContext)("page"),S=()=>(0,a.useContext)(k),x=(k.Provider,e=>{const t=S();e=e||t;const o=(0,h.useSelect)((t=>t(E.QUERY_STATE_STORE_KEY).getValueForQueryContext(e,void 0)),[e]),{setValueForQueryContext:r}=(0,h.useDispatch)(E.QUERY_STATE_STORE_KEY);return[o,(0,a.useCallback)((t=>{r(e,t)}),[e,r])]}),O=(e,t,o)=>{const r=S();o=o||r;const l=(0,h.useSelect)((r=>r(E.QUERY_STATE_STORE_KEY).getValueForQueryKey(o,e,t)),[o,e]),{setQueryValue:n}=(0,h.useDispatch)(E.QUERY_STATE_STORE_KEY);return[l,(0,a.useCallback)((t=>{n(o,e,t)}),[o,e,n])]},C=({queryAttribute:e,queryPrices:t,queryStock:o,queryRating:r,queryState:l,isEditor:n=!1})=>{let c=S();c=`${c}-collection-data`;const[s]=x(c),[i,u]=O("calculate_attribute_counts",[],c),[p,m]=O("calculate_price_range",null,c),[d,w]=O("calculate_stock_status_counts",null,c),[f,g]=O("calculate_rating_counts",null,c),k=v(e||{}),C=v(t),T=v(o),N=v(r);(0,a.useEffect)((()=>{"object"==typeof k&&Object.keys(k).length&&(i.find((e=>(0,_.objectHasProp)(k,"taxonomy")&&e.taxonomy===k.taxonomy))||u([...i,k]))}),[k,i,u]),(0,a.useEffect)((()=>{p!==C&&void 0!==C&&m(C)}),[C,m,p]),(0,a.useEffect)((()=>{d!==T&&void 0!==T&&w(T)}),[T,w,d]),(0,a.useEffect)((()=>{f!==N&&void 0!==N&&g(N)}),[N,g,f]);const[j,q]=(0,a.useState)(n),[P]=(0,y.d7)(j,200);j||q(!0);const R=(0,a.useMemo)((()=>(e=>{const t=e;return Array.isArray(e.calculate_attribute_counts)&&(t.calculate_attribute_counts=(0,b.di)(e.calculate_attribute_counts.map((({taxonomy:e,queryType:t})=>({taxonomy:e,query_type:t})))).asc(["taxonomy","query_type"])),t})(s)),[s]);return(e=>{const{namespace:t,resourceName:o,resourceValues:r=[],query:l={},shouldSelect:n=!0}=e;if(!t||!o)throw new Error("The options object must have valid values for the namespace and the resource properties.");const c=(0,a.useRef)({results:[],isLoading:!0}),s=v(l),i=v(r),u=(()=>{const[,e]=(0,a.useState)();return(0,a.useCallback)((t=>{e((()=>{throw t}))}),[])})(),p=(0,h.useSelect)((e=>{if(!n)return null;const r=e(E.COLLECTIONS_STORE_KEY),l=[t,o,s,i],c=r.getCollectionError(...l);if(c){if(!(0,_.isError)(c))throw new Error("TypeError: `error` object is not an instance of Error constructor");u(c)}return{results:r.getCollection(...l),isLoading:!r.hasFinishedResolution("getCollection",l)}}),[t,o,i,s,n]);return null!==p&&(c.current=p),c.current})({namespace:"/wc/store/v1",resourceName:"products/collection-data",query:{...l,page:void 0,per_page:void 0,orderby:void 0,order:void 0,...R},shouldSelect:P})},T=({attributes:e,setAttributes:t})=>{const{showCounts:o,selectType:l,displayStyle:n}=e;return(0,r.createElement)(u.InspectorControls,{key:"inspector"},(0,r.createElement)(p.PanelBody,{title:(0,m.__)("Display Settings","woocommerce")},(0,r.createElement)(p.ToggleControl,{label:(0,m.__)("Display product count","woocommerce"),checked:o,onChange:()=>t({showCounts:!o})}),(0,r.createElement)(p.__experimentalToggleGroupControl,{label:(0,m.__)("Allow selecting multiple options?","woocommerce"),value:l||"single",onChange:e=>t({selectType:e}),className:"wc-block-attribute-filter__multiple-toggle"},(0,r.createElement)(p.__experimentalToggleGroupControlOption,{value:"multiple",label:(0,m._x)("Multiple","Number of filters","woocommerce")}),(0,r.createElement)(p.__experimentalToggleGroupControlOption,{value:"single",label:(0,m._x)("Single","Number of filters","woocommerce")})),(0,r.createElement)(p.__experimentalToggleGroupControl,{label:(0,m.__)("Display Style","woocommerce"),value:n,onChange:e=>t({displayStyle:e}),className:"wc-block-attribute-filter__display-toggle"},(0,r.createElement)(p.__experimentalToggleGroupControlOption,{value:"list",label:(0,m.__)("List","woocommerce")}),(0,r.createElement)(p.__experimentalToggleGroupControlOption,{value:"dropdown",label:(0,m.__)("Dropdown","woocommerce")}))))},N=({placeholder:e})=>(0,r.createElement)("div",{className:"wc-interactivity-dropdown"},(0,r.createElement)("div",{className:"wc-interactivity-dropdown__dropdown"},(0,r.createElement)("div",{className:"wc-interactivity-dropdown__dropdown-selection",tabIndex:0},(0,r.createElement)("span",{className:"wc-interactivity-dropdown__placeholder"},e),(0,r.createElement)("span",{className:"wc-interactivity-dropdown__svg-container"},(0,r.createElement)("svg",{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",width:"30",height:"30"},(0,r.createElement)("path",{d:"M17.5 11.6L12 16l-5.5-4.4.9-1.2L12 14l4.5-3.6 1 1.2z"})))))),j=JSON.parse('{"name":"woocommerce/product-filter-stock-status","version":"1.0.0","title":"Product Filter: Stock Status (Experimental)","description":"Enable customers to filter the product collection by stock status.","category":"woocommerce","keywords":["WooCommerce","filter","stock"],"supports":{"interactivity":true,"html":false,"multiple":false,"inserter":false,"color":{"text":true,"background":false}},"attributes":{"className":{"type":"string","default":""},"showCounts":{"type":"boolean","default":false},"displayStyle":{"type":"string","default":"list"},"selectType":{"type":"string","default":"multiple"},"isPreview":{"type":"boolean","default":false}},"usesContext":["query","queryId"],"ancestor":["woocommerce/product-filter"],"textdomain":"woocommerce","apiVersion":2,"$schema":"https://schemas.wp.org/trunk/block.json"}');(()=>{const{experimentalBlocksEnabled:e}=(0,s.getSetting)("wcBlocksConfig",{experimentalBlocksEnabled:!1});return e})()&&(0,l.registerBlockType)(j,{icon:{src:(0,r.createElement)(n.A,{icon:c.A,className:"wc-block-editor-components-block-icon"})},edit:e=>{const t=(0,u.useBlockProps)({className:(0,i.A)("wc-block-stock-filter",e.attributes.className)}),{showCounts:o,displayStyle:l}=e.attributes,n=(0,s.getSetting)("stockStatusOptions",{}),{results:c}=C({queryStock:!0,queryState:{},isEditor:!0}),y=(0,a.useMemo)((()=>Object.entries(n).map((([e,t])=>{var l,n;const s=null==c||null===(l=c.stock_status_counts)||void 0===l||null===(n=l.find((t=>t.status===e)))||void 0===n?void 0:n.count;return{value:e,label:(0,r.createElement)(w,{name:t,count:o&&s?Number(s):null}),count:s||0}})).filter((e=>e.count>0))),[n,c,o]);return(0,r.createElement)(r.Fragment,null,(0,r.createElement)("div",{...t},(0,r.createElement)(T,{...e}),(0,r.createElement)(p.Disabled,null,(0,r.createElement)("div",{className:(0,i.A)(`style-${l}`,{"is-loading":!1})},"dropdown"===l?(0,r.createElement)(r.Fragment,null,(0,r.createElement)(N,{placeholder:"single"===e.attributes.selectType?(0,m.__)("Select stock status","woocommerce"):(0,m.__)("Select stock statuses","woocommerce")})):(0,r.createElement)(d.CheckboxList,{className:"wc-block-stock-filter-list",options:y,checked:[],onChange:()=>{},isLoading:!1,isDisabled:!0})))))}})},5400:()=>{},1832:()=>{},1609:e=>{"use strict";e.exports=window.React},6087:e=>{"use strict";e.exports=window.wp.element},7723:e=>{"use strict";e.exports=window.wp.i18n},923:e=>{"use strict";e.exports=window.wp.isShallowEqual},5573:e=>{"use strict";e.exports=window.wp.primitives}},l={};function n(e){var t=l[e];if(void 0!==t)return t.exports;var o=l[e]={exports:{}};return r[e].call(o.exports,o,o.exports,n),o.exports}n.m=r,e=[],n.O=(t,o,r,l)=>{if(!o){var c=1/0;for(u=0;u<e.length;u++){for(var[o,r,l]=e[u],s=!0,a=0;a<o.length;a++)(!1&l||c>=l)&&Object.keys(n.O).every((e=>n.O[e](o[a])))?o.splice(a--,1):(s=!1,l<c&&(c=l));if(s){e.splice(u--,1);var i=r();void 0!==i&&(t=i)}}return t}l=l||0;for(var u=e.length;u>0&&e[u-1][2]>l;u--)e[u]=e[u-1];e[u]=[o,r,l]},n.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return n.d(t,{a:t}),t},o=Object.getPrototypeOf?e=>Object.getPrototypeOf(e):e=>e.__proto__,n.t=function(e,r){if(1&r&&(e=this(e)),8&r)return e;if("object"==typeof e&&e){if(4&r&&e.__esModule)return e;if(16&r&&"function"==typeof e.then)return e}var l=Object.create(null);n.r(l);var c={};t=t||[null,o({}),o([]),o(o)];for(var s=2&r&&e;"object"==typeof s&&!~t.indexOf(s);s=o(s))Object.getOwnPropertyNames(s).forEach((t=>c[t]=()=>e[t]));return c.default=()=>e,n.d(l,c),l},n.d=(e,t)=>{for(var o in t)n.o(t,o)&&!n.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:t[o]})},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),n.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.j=2689,(()=>{var e={2689:0};n.O.j=t=>0===e[t];var t=(t,o)=>{var r,l,[c,s,a]=o,i=0;if(c.some((t=>0!==e[t]))){for(r in s)n.o(s,r)&&(n.m[r]=s[r]);if(a)var u=a(n)}for(t&&t(o);i<c.length;i++)l=c[i],n.o(e,l)&&e[l]&&e[l][0](),e[l]=0;return n.O(u)},o=self.webpackChunkwebpackWcBlocksMainJsonp=self.webpackChunkwebpackWcBlocksMainJsonp||[];o.forEach(t.bind(null,0)),o.push=t.bind(null,o.push.bind(o))})();var c=n.O(void 0,[94],(()=>n(9477)));c=n.O(c),((this.wc=this.wc||{}).blocks=this.wc.blocks||{})["product-filter-stock-status"]=c})();
(window.webpackJsonp=window.webpackJsonp||[]).push([[18],{"KHd+":function(e,t,n){"use strict";function s(e,t,n,s,o,r,a,i){var l,c="function"==typeof e?e.options:e;if(t&&(c.render=t,c.staticRenderFns=n,c._compiled=!0),s&&(c.functional=!0),r&&(c._scopeId="data-v-"+r),a?(l=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),o&&o.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(a)},c._ssrRegister=l):o&&(l=i?function(){o.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:o),l)if(c.functional){c._injectStyles=l;var u=c.render;c.render=function(e,t){return l.call(t),u(e,t)}}else{var d=c.beforeCreate;c.beforeCreate=d?[].concat(d,l):[l]}return{exports:e,options:c}}n.d(t,"a",(function(){return s}))},tmv7:function(e,t,n){"use strict";n.r(t);var s={name:"SelectField",props:["value","label","props"],data:function(){return{selectedValue:null}},mounted:function(){this.selectedValue=this.value},watch:{selectedValue:function(e){this.$emit("input",e)}},methods:{onChange:function(){}}},o=n("KHd+"),r=Object(o.a)(s,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",[n("label",{attrs:{for:""}},[e._v("\n        "+e._s(e.label)+"\n    ")]),e._v(" "),n("selectpicker",{attrs:{list:e.props.items,multi:!1,tagged:!1,search:!0,placeholder:"Выберите значение",searchPlaceholder:"Искать"},model:{value:e.selectedValue,callback:function(t){e.selectedValue=t},expression:"selectedValue"}})],1)}),[],!1,null,"8f3ba2ec",null);t.default=r.exports}}]);
//# sourceMappingURL=18.js.map
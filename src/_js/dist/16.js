(window.webpackJsonp=window.webpackJsonp||[]).push([[16],{"KHd+":function(n,e,t){"use strict";function i(n,e,t,i,a,o,l,s){var r,d="function"==typeof n?n.options:n;if(e&&(d.render=e,d.staticRenderFns=t,d._compiled=!0),i&&(d.functional=!0),o&&(d._scopeId="data-v-"+o),l?(r=function(n){(n=n||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(n=__VUE_SSR_CONTEXT__),a&&a.call(this,n),n&&n._registeredComponents&&n._registeredComponents.add(l)},d._ssrRegister=r):a&&(r=s?function(){a.call(this,(d.functional?this.parent:this).$root.$options.shadowRoot)}:a),r)if(d.functional){d._injectStyles=r;var c=d.render;d.render=function(n,e){return r.call(e),c(n,e)}}else{var u=d.beforeCreate;d.beforeCreate=u?[].concat(u,r):[r]}return{exports:n,options:d}}t.d(e,"a",(function(){return i}))},"sZw+":function(n,e,t){"use strict";t.r(e);var i=t("LvDl"),a={name:"MultilangField",props:["value","label","props","field","additionalValues"],data:function(){return{counter:1,mainModel:null,langModel:{},curLangIndex:0}},created:function(){this.mainModel=this.value},mounted:function(){var n=this;this.additionalValues&&Object(i.each)(this.additionalValues.items,(function(e){var t=0,a="";Object(i.each)(e,(function(n){"lang_id"===n.field&&(t=n.value),"data"===n.field&&(a=n.value)})),n.langModel[t]=Object(i.clone)(a),n.$forceUpdate(),n.counter++})),this.emitLangsChange()},watch:{mainModel:function(n){this.onChange(n)}},methods:{test:function(n,e){this.langModel[n]=e,this.$forceUpdate(),this.emitLangsChange()},onChangeLang:function(n){this.curLangIndex=n},onChange:function(n){this.$emit("input",n)},emitLangsChange:function(){var n=this,e=[];Object(i.each)(this.langModel,(function(t,a){e.push([{field:"entity_id",value:n.props.entity_id},{field:"entity_class",value:n.props.entity_class},{field:"lang_id",value:a},{field:"attribute",value:n.field},{field:"data",value:Object(i.clone)(t)}])})),this.$emit("additionalchange",{items:e,relationClass:this.props.relationClass})}}},o=t("KHd+"),l=Object(o.a)(a,(function(){var n=this,e=n.$createElement,t=n._self._c||e;return t("div",{staticStyle:{"margin-top":"10px"}},[t("label",{attrs:{for:""}},[n._v("\n        "+n._s(n.label)+"\n    ")]),n._v(" "),t("div",[t("div",{staticClass:"langs btn-group",attrs:{role:"group"}},n._l(n.props.langs,(function(e,i){return t("button",{class:"btn btn-secondary"+(n.curLangIndex===i?" active":""),attrs:{"aria-pressed":n.curLangIndex===i},on:{click:function(e){return n.onChangeLang(i)}}},[n._v("\n                "+n._s(e.code)+"\n            ")])})),0)]),n._v(" "),n._l(n.props.langs,(function(e,i){return t("div",["0"===e.is_default?[n.curLangIndex===i?t(n.props.component,{key:"multiinput"+n.counter+n.field,tag:"component",attrs:{field:n.field,props:n.props,label:""},on:{input:function(t){return n.test(e.id,t)}},model:{value:n.langModel[e.id],callback:function(t){n.$set(n.langModel,e.id,t)},expression:"langModel[lang.id]"}}):n._e()]:[n.curLangIndex===i?t(n.props.component,{key:"multiinput"+n.counter+n.field,tag:"component",attrs:{field:n.field,props:n.props,label:""},model:{value:n.mainModel,callback:function(e){n.mainModel=e},expression:"mainModel"}}):n._e()]],2)}))],2)}),[],!1,null,"19985eff",null);e.default=l.exports}}]);
//# sourceMappingURL=16.js.map
(window.webpackJsonp=window.webpackJsonp||[]).push([[7],{"KHd+":function(t,e,n){"use strict";function o(t,e,n,o,s,i,r,a){var c,d="function"==typeof t?t.options:t;if(e&&(d.render=e,d.staticRenderFns=n,d._compiled=!0),o&&(d.functional=!0),i&&(d._scopeId="data-v-"+i),r?(c=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),s&&s.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(r)},d._ssrRegister=c):s&&(c=a?function(){s.call(this,(d.functional?this.parent:this).$root.$options.shadowRoot)}:s),c)if(d.functional){d._injectStyles=c;var l=d.render;d.render=function(t,e){return c.call(e),l(t,e)}}else{var u=d.beforeCreate;d.beforeCreate=u?[].concat(u,c):[c]}return{exports:t,options:d}}n.d(e,"a",(function(){return o}))},TYBQ:function(t,e,n){"use strict";(function(t){e.a={name:"VersionField",props:["value","label","props"],methods:{onRestore:function(){t.ajax({method:"POST",url:"/admin/version-restore",data:{id:this.props.id},success:function(t){t.result?(alert("Успешно восстановлено"),window.location.reload()):alert("Ошибка восстановления")}})}}}}).call(this,n("EVdn"))},cazo:function(t,e,n){"use strict";n.r(e);var o=n("TYBQ").a,s=n("KHd+"),i=Object(s.a)(o,(function(){var t=this.$createElement,e=this._self._c||t;return e("div",[e("div",[this._v("\n        Версия "+this._s(this.value)+"\n    ")]),this._v(" "),e("div",[e("button",{staticClass:"btn btn-default",on:{click:this.onRestore}},[this._v("\n            Восстановить\n        ")])])])}),[],!1,null,"0ea85be5",null);e.default=i.exports}}]);
//# sourceMappingURL=7.js.map
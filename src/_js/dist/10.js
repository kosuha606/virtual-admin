(window.webpackJsonp=window.webpackJsonp||[]).push([[10],{D2cJ:function(t,s,a){"use strict";a.r(s);var e={name:"DashboardPage",props:["props"],data:function(){return{nowOffset:0,orders_dynamic:this.props.orders_dynamic}},watch:{nowOffset:function(t){var s=this;Request.get("/admin/dashboard/orders_chart",{now_offset:t},(function(t){t.result&&(s.orders_dynamic=t.data,s.$forceUpdate(),s.loadChart())}))}},mounted:function(){this.loadChart()},methods:{changeNowOffset:function(t){this.nowOffset=this.nowOffset+t},loadChart:function(){var t=document.getElementById("myChart");t.height=200;new Chart(t,{type:"line",data:{labels:this.orders_dynamic.dates,datasets:[{label:"Кол-во заказов",data:this.orders_dynamic.values,borderWidth:1}]},options:{maintainAspectRatio:!1,scales:{yAxes:[{ticks:{beginAtZero:!0}}]}}})}}},i=a("KHd+"),r=Object(i.a)(e,(function(){var t=this,s=t.$createElement,a=t._self._c||s;return a("div",[a("div",{staticClass:"content-header"}),t._v(" "),a("div",{staticClass:"content"},[a("div",{staticClass:"container-fluid"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},[a("div",{staticClass:"card"},[t._m(0),t._v(" "),t._m(1),t._v(" "),a("div",{staticClass:"card-footer clearfix"},[a("button",{staticClass:"btn btn-primary",on:{click:function(s){return t.changeNowOffset(-7)}}},[a("i",{staticClass:"fa fa-arrow-left",attrs:{"data-v-02c5127a":""}}),t._v("\n                                Назад -7 дней\n                            ")]),t._v(" "),a("button",{staticClass:"btn btn-primary",on:{click:function(s){return t.changeNowOffset(7)}}},[t._v("\n                                Вперед +7 дней\n                                "),a("i",{staticClass:"fa fa-arrow-right",attrs:{"data-v-02c5127a":""}})]),t._v(" "),0!==t.nowOffset?a("b",[t._v("\n                                Смещение:\n                                "+t._s(t.nowOffset)+" дней\n                            ")]):t._e()])])])]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"card"},[t._m(2),t._v(" "),a("div",{staticClass:"card-body"},[t._v("\n                            "+t._s(t.$pluralize(t.props.articles_count,"нет статей","%d статья","%d статьи","%d статьей"))+"\n                        ")]),t._v(" "),t._m(3)])]),t._v(" "),a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"card"},[t._m(4),t._v(" "),a("div",{staticClass:"card-body"},[t._v("\n                            "+t._s(t.$pluralize(t.props.orders_count,"нет заказов","%d заказ","%d заказа","%d заказов"))+"\n                        ")]),t._v(" "),t._m(5)])])]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"card"},[t._m(6),t._v(" "),a("div",{staticClass:"card-body"},[t._v("\n                            "+t._s(t.$pluralize(t.props.products_count,"нет продуктов","%d продукт","%d продукта","%d продуктов"))+"\n                        ")]),t._v(" "),t._m(7)])]),t._v(" "),a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"card"},[t._m(8),t._v(" "),a("div",{staticClass:"card-body"},[t._v("\n                            "+t._s(t.$pluralize(t.props.search_index_count,"нет записей","%d запись","%d записи","%d записей"))+"\n                        ")]),t._v(" "),t._m(9)])])])])])])}),[function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"card-header"},[s("h3",[this._v("Динамика заказов")])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"card-body"},[s("canvas",{attrs:{id:"myChart"}})])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"card-header"},[s("h3",[this._v("Всего статей")])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"card-footer clearfix"},[s("a",{staticClass:"btn btn-primary",attrs:{href:"/admin/article/list"}},[this._v("\n                                Статьи\n                            ")])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"card-header"},[s("h3",[this._v("Всего заказов")])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"card-footer clearfix"},[s("a",{staticClass:"btn btn-primary",attrs:{href:"/admin/order/list"}},[this._v("\n                                Заказы\n                            ")])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"card-header"},[s("h3",[this._v("Всего продуктов")])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"card-footer clearfix"},[s("a",{staticClass:"btn btn-primary",attrs:{href:"/admin/product/list"}},[this._v("\n                                Продукты\n                            ")])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"card-header"},[s("h3",[this._v("В поиске")])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"card-footer clearfix"},[s("a",{staticClass:"btn btn-primary",attrs:{href:"/admin/search/detail"}},[this._v("\n                                Индекс\n                            ")])])}],!1,null,"46f01d5e",null);s.default=r.exports},"KHd+":function(t,s,a){"use strict";function e(t,s,a,e,i,r,n,c){var d,o="function"==typeof t?t.options:t;if(s&&(o.render=s,o.staticRenderFns=a,o._compiled=!0),e&&(o.functional=!0),r&&(o._scopeId="data-v-"+r),n?(d=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(n)},o._ssrRegister=d):i&&(d=c?function(){i.call(this,(o.functional?this.parent:this).$root.$options.shadowRoot)}:i),d)if(o.functional){o._injectStyles=d;var l=o.render;o.render=function(t,s){return d.call(s),l(t,s)}}else{var _=o.beforeCreate;o.beforeCreate=_?[].concat(_,d):[d]}return{exports:t,options:o}}a.d(s,"a",(function(){return e}))}}]);
//# sourceMappingURL=10.js.map
<template>
    <div>
        <vue-table
                :default-sort="defaultSort"
                :id="id"
                ref="mainList"
                :sync-url="fetchData"
                :cell-components="vueTableFields"
                :filter-components="filterComponents"
                :mass-operation-components="massOperationComponents"
        >
            <template v-slot:pagination_top>
                <div v-if="$refs && $refs.mainList">
                    <button v-if="$refs.mainList.pagination.appendMode" @click="$refs.mainList.pagination.nextPage()" type="button">
                        Показать еще
                    </button>
                    <div v-else class="pagination-wrapper row">
                        <div class="col-md-10">
                            <ul class="pagination">
                                <li class="pagination-item">
                                    <button class="btn btn-default" @click="$refs.mainList.pagination.gotoBegin()" type="button">В начало</button>
                                </li>
                                <li class="pagination-item">
                                    <button class="btn btn-default" @click="$refs.mainList.pagination.prevPage()" type="button">Назад</button>
                                </li>
                                <li style="padding: 0 10px" v-if="$refs.mainList.pagination.page > 1">
                                    ...
                                </li>
                                <li :class="{'pagination-item':1, 'pagination-item__active': 0}" v-if="$refs.mainList.pagination.page > 1">
                                    <button class="btn btn-default" @click="$refs.mainList.pagination.gotoPage($refs.mainList.pagination.page-1)" type="button">
                                        {{ $refs.mainList.pagination.page-1 }}
                                    </button>
                                </li>
                                <li :class="{'pagination-item':1, 'pagination-item__active': 1}">
                                    <button class="btn btn-default" @click="$refs.mainList.pagination.gotoPage($refs.mainList.pagination.page)" type="button">
                                        {{ $refs.mainList.pagination.page }}
                                    </button>
                                </li>
                                <li :class="{'pagination-item':1, 'pagination-item__active': 0}" v-if="$refs.mainList.pagination.page < $refs.mainList.pagination.pagesCount()">
                                    <button class="btn btn-default" @click="$refs.mainList.pagination.gotoPage($refs.mainList.pagination.page+1)" type="button">
                                        {{ $refs.mainList.pagination.page+1 }}
                                    </button>
                                </li>
                                <li style="padding: 0 10px" v-if="$refs.mainList.pagination.page < $refs.mainList.pagination.pagesCount()">
                                    ...
                                </li>
                                <li class="pagination-item">
                                    <button class="btn btn-default" @click="$refs.mainList.pagination.nextPage()" type="button">Вперед</button>
                                </li>
                                <li class="pagination-item">
                                    <button class="btn btn-default" @click="$refs.mainList.pagination.gotoEnd()" type="button">В конец</button>
                                </li>
                            </ul>
                        </div>
                        <div class="items-per-page col-md-2">
                            <select class="form-control" v-model="$refs.mainList.pagination.itemsPerPage">
                                <option
                                        :selected="variant==$refs.mainList.pagination.itemsPerPage"
                                        v-for="variant in $refs.mainList.pagination.itemsPerPageVariants"
                                        :value="variant">
                                    {{ variant }}
                                </option>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </template>
            <template v-slot:list>
                <div v-if="$refs.mainList">
                    <div class="table-info">
                        записи с {{ $refs.mainList.pagination.getOffsetBegin()+1 }}
                        по {{ $refs.mainList.pagination.getOffsetEnd() }},
                        всего: {{ $refs.mainList.pagination.getTotal() }} шт.
                        {{ $refs.mainList.pagination.page }}
                        из {{ $refs.mainList.pagination.pagesCount() }} стр.
                    </div>
                    <table :class="{'table table-striped table-bordered': 1, 'table-loading': $refs.mainList.isLoading}">
                        <thead>
                        <tr>
                            <th
                                    :width="component.attrs ? component.attrs.width : ''"
                                    v-for="component in $refs.mainList.cellComponents">
                                {{ component.label }}
                                <div v-if="component.field && component.props.sort !== false" class="table-sort">
                                    <button :class="{'btn btn-default': 1, 'table-sort-active': ($refs.mainList.sort.field == component.field) && ($refs.mainList.sort.direction == 'desc')}" @click="$refs.mainList.onSort(component.field, 'desc')" type="button">&uarr;</button>
                                    <button :class="{'btn btn-default': 1, 'table-sort-active': ($refs.mainList.sort.field == component.field) && ($refs.mainList.sort.direction == 'asc')}" @click="$refs.mainList.onSort(component.field, 'asc')" type="button">&darr;</button>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in $refs.mainList.items">
                            <template v-for="component in $refs.mainList.cellComponents">
                                <component
                                        v-if="component.massOperation"
                                        @mass-select="$refs.mainList.onMassComponentSelect($event, component)"
                                        @mass-unselect="$refs.mainList.onMassComponentUnselect($event, component)"
                                        :key="index+'_'+component.field+component.label"
                                        :mass-operations="massOperations"
                                        :component="component"
                                        :is="component.component"
                                        :field="component.field"
                                        :props="component.props"
                                        :item="item"
                                ></component>
                                <component
                                        v-else
                                        :key="index+'_'+component.field+component.label"
                                        :is="component.component"
                                        :field="component.field"
                                        :props="component.props"
                                        :item="item"
                                        :value="item[component.field]"
                                ></component>
                            </template>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </template>
            <template v-slot:filter>
                <div class="vue-table-filter" v-if="$refs && $refs.mainList">
                    <div class="row">
                        <div class="col-md-4"
                             v-for="component in $refs.mainList.filterComponents"
                        >
                            <component
                                    v-model="$refs.mainList.filters[component.field]"
                                    :key="'mass_'+component.field+component.label"
                                    :is="component.component"
                                    :name="component.field"
                                    :label="component.label"
                                    :props="component.props"
                            ></component>
                        </div>
                    </div>
                    <div class="vue-table-filter-reset mt-10">
                        <button class="btn btn-default" @click="$refs.mainList.resetFilter" v-if="$refs.mainList.filterComponents.length">
                            Сбросить
                        </button>
                    </div>
                </div>
            </template>
        </vue-table>
    </div>
</template>

<script>
    import {VueTable} from 'vue-component-table';
    import StringCell from './concrete/StringCell';

    export default {
        name: "List",
        props: {
            id: String,
            entityUrl: String,
            cellComponents: Array,
            filterComponents: Array,
            massOperationComponents: Array,
            defaultSort: Object,
        },
        components: {
            VueTable,
            StringCell,
        },
        computed: {
            vueTableFields() {
                var vm = this;
                let result = [];
                this.cellComponents.forEach(function(i) {
                    var props = i.props ? i.props : {};
                    if (i.props && i.props.link) {
                        props.link = function(item) {
                            return vm.entityUrl+'/detail?id='+item.id;
                        };
                    }

                    if (i.props && i.props.url) {
                        var url = i.props.url;
                        props.url = function(item) {
                            return url.toString().replace('%id%', item.id);
                        };
                    }

                    result.push({
                        component: i.component,
                        field: i.field,
                        label: i.label,
                        props: props,
                    })
                });

                return result;
            }
        },
        methods: {
            fetchData(success, requestData) {
                var reqData = {};

                if (requestData) {
                    reqData = {};
                    reqData.page = requestData.pagination.page;
                    reqData.per_page = requestData.pagination.itemsPerPage;
                    reqData.sortField = requestData.sort.field;
                    reqData.sortDir = requestData.sort.direction;
                    reqData.filter = requestData.filters;
                }

                this.$root.startProgress();
                $.ajax({
                    method: 'GET',
                    url: this.entityUrl+'/list',
                    data: reqData
                }).done((response) => {
                    if (success) {
                        success({
                            data: {
                                items: response.models,
                                total: response.pagination.totals
                            }
                        })
                    }
                    this.$root.stopProgress();
                }).fail(() => {
                    alert('server error');
                    this.$root.stopProgress();
                })
            }
        }
    }
</script>

<style scoped>

</style>
<div class="top-page">
    <ul class="uk-breadcrumb ui dividing header">
        <li><a class="uk-link-heading" href=""><?= h(__('Dashboard')) ?></a></li>
        <li><a class="uk-link-heading" href=""><?= h(__('Category')) ?></a></li>
    </ul>
    <ul uk-accordion="multiple: true">
        <li class="uk-open">
            <a class="uk-accordion-title" href="#"><?= h(__('Search')) ?></a>
            <div class="ui equal width form uk-accordion-content">
                <div class="fields">
                    <div class="field">
                        <label><?=h(__('Name'));?></label>
                        <div class="ui focus input">
                            <input type="text" v-model="search.name" placeholder="<?=h(__('Name'));?>">
                        </div>
                    </div>
                </div>

                <div class="fields">
                    <hr class="uk-divider-icon" />
                </div>

                <div class="fields">
                    <label>&nbsp;</label>
                    <div class="uk-position-bottom-right">
                        <div class="ui mini buttons">
                            <button class="ui button" @click="resetSearch()"><i class="redo icon"></i><?=h(__('Reset'));?></button>
                            <div class="or"></div>
                            <button class="ui positive button" @click="getData()"><i class="search icon"></i><?=h(__('Search'));?></button>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>
<div class="uk-auto">
    <table class="uk-table uk-table-hover uk-table-divider">
        <thead>
            <tr>
                <th class="uk-table-shrink"><?= h(__('No')) ?></th>
                <th class="uk-table-expand"><?= h(__('Name')) ?></th>
                <th class="uk-width-small">
                    <button class="uk-button uk-button-primary uk-button-small" @click="addData()"><?= h(__('Add')) ?></button>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(cat, index) in categories">
                <td class="uk-table-shrink">{{ index + 1 }}</td>
                <td class="uk-table-expand">{{ cat.name }}</td>
                <td class="uk-width-small">
                    <a title="<?= h(__('Edit')) ?>" @click="editData(cat.id)" data-uk-tooltip><i class="edit icon"></i></a>
                    <a style="color:red" title="<?= h(__('Delete')) ?>" @click="deleteComfirm(cat.id)" data-uk-tooltip><i class="trash alternate icon"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div>
    <ul class="uk-pagination uk-flex-right uk-margin-medium-top" uk-margin>
        <li><a href="#"><span uk-pagination-previous></span></a></li>
        <li class="uk-active" v-for="item in totalPage"><a @click="changePage(item)">{{item}}</a></li>
        <li><a href="#"><span uk-pagination-next></span></a></li>
    </ul>
</div>
<div class="ui small modal" id="detailModal">
    <i class="close icon" @click="close()" style="top: 10px; right: 10px; color: black"></i>
    <div class="header">
        <?= h(__('Category Details')) ?>
    </div>
    <div class="content">
        <div class="ui equal width form">
            <div class="fields">
                <div class="field">
                    <label><?=h(__('Name'));?></label>
                    <div class="ui focus input">
                        <input type="text" v-model="categoryDetail.name" placeholder="<?=h(__('Name'));?>">
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.categoryDetail.name && !$v.categoryDetail.name.required"><?= h(__('Field is required')) ?></div>
                    <div class="ui pointing red basic label" v-if="$v.categoryDetail.name && !$v.categoryDetail.name.minLength"><?= h(__('Name at least 6 characters')) ?></div>
                    <div class="ui pointing red basic label" v-if="$v.categoryDetail.name && !$v.categoryDetail.name.maxLength"><?= h(__('Name up to 255 characters')) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="actions">
        <button class="ui mini teal button" @click="saveData()"><i class="edit icon"></i><?= h(__('Save')) ?></button>
        <button class="ui mini default button" @click="close()"><i class="redo icon"></i><?= h(__('Cancel')) ?></button>
    </div>
</div>
<div class="ui mini modal" id="deleteModal">
    <i class="close icon" style="top: 10px; right: 10px; color: black"></i>
    <div class="ui header red">
        <?= h(__('Delete Category Item')) ?>
    </div>
    <div class="content" style="text-align:center">
        <h3><?= h(__('Are you sure ?')) ?></h3>
    </div>
    <div class="actions">
        <button class="ui mini red button" @click="deleteData()"><i class="trash icon"></i><?= h(__('Delete')) ?></button>
    </div>
</div>

<?php $this->start("scriptcontent");?>
<script>
const { required, minLength, maxLength } = window.validators;
new Vue({
    mixins: [mixin],
    el: '#app',
    data() {
        return {
            search: {
                name: '',
                del_flg:0,
                page:1
            },
            categories:[],
            categoryDetail: {
                id: '',
                name: ''
            },
            catId: '',
            totalPage: '',
            action:'',
        }
    },
    validations() {
        if(this.action === 'search'){
            return {
                categoryDetail:{}
            }
        }
        if(this.action === 'savedata'){
            return {
                categoryDetail :{
                    name: {
                        required,
                        minLength: minLength(6),
                        maxLength: maxLength(255)
                    }
                }
            };
        }
        return {
            categoryDetail: {}
        };
    },
    created() {
    },
    mounted() {
        this.getData();
    },
    updated() {

    },
    computed: {
        now: function() {
            return Date.now();
        }
    },
    methods: {
        addData() {
            $('#detailModal').modal('show');
        },
        async getData() {
            let response = await this.API('GET', 'category/list', null, this.search);
            if (response.status_code === '200') {
                this.categories = response.data;
                this.showSuccessToast(response.message);
                this.totalPage = response.totalPage;
            }
        },
        async refeshData() {
            let response = await this.API('GET', 'category/list');
            if (response.status_code === '200') {
                this.categories = response.data;
                this.totalPage = response.totalPage;
            }
        },
        async editData(id) {
            let response = await this.API('GET', 'category/get', null, {
                id: id
            });
            if (response.status_code === '200') {
                this.categoryDetail = response.data;
            }
            $('#detailModal').modal('show');
        },
        async saveData() {
            this.action = 'savedata';
            this.$v.$touch();
            if(this.$v.$invalid){
                return;
            };
            let response = await this.API('POST', 'category/save', this.categoryDetail);
            if (response.status_code === '200') {
                this.showSuccessToast(response.message);
                this.categoryDetail = {
                    name: '',
                };
                this.refeshData();
                $('#detailModal').modal('hide');
                this.action = 'search';
            } else {
                this.showErrorToast(response.message);
            }
        },
        deleteComfirm(id) {
            this.catId = id;
            $('#deleteModal').modal('show');
        },
        async deleteData() {
            let response = await this.API('POST', 'category/delete', {
                id: this.catId
            });
            if (response.status_code === '200') {
                this.showSuccessToast(response.message);
            } else {
                this.showErrorToast(response.message);
            }
            this.refeshData();
            $('#deleteModal').modal('hide');
        },
        async changePage(page){
            this.action = 'search';
            this.$v.$touch();
            if(this.$v.$invalid){
                return;
            };
            let response = await this.API('GET', 'category/list', null, {page:page});
            if (response.status_code === '200') {
                this.categories = response.data;
                this.totalPage = response.totalPage;
            }
        },
        resetSearch() {
            this.search = {
                name: ''
            }
            this.refeshData();
            this.showSuccessToast('Reset Search');
        },
        close: function(){
            $('.ui.modal').modal('hide');
            this.action = 'search';
            this.categoryDetail = {
                name: ''
            }
        }
    }
});
</script>
<?php $this->end(); ?>
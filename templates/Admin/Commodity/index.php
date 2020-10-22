<div class="top-page">
    <ul class="uk-breadcrumb ui dividing header">
        <li><a class="uk-link-heading section" href=""><?= h(__('Dashboard')) ?></a></li>
        <li><a class="uk-link-heading section" href=""><?= h(__('Commodity')) ?></a></li>
    </ul>

    <ul uk-accordion="multiple: true">
        <li class="uk-open">
            <a class="uk-accordion-title" href="#"><?= h(__('Search')) ?></a>
            <div class="ui equal width form uk-accordion-content">
                <div class="fields">
                    <div class="field">
                        <label><?=h(__('Commodity Name')) ?></label>
                        <div class="ui focus input">
                            <input type="text" v-model="search.name" placeholder="<?=h(__('Commodity Name')) ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label><?=h(__('Category')) ?></label>
                        <div class="ui focus input">
                            <select  class="ui dropdown" id="category_search" v-model="search.category_id">
                                <option value=""><?=h(__('Please choose Category'))?></option>
                                <option v-for="category in categories" v-bind:data-value="category.id">{{category.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <label><?=h(__('Date Create')) ?></label>
                        <calendar placeholder="Date Create" v-model="search.created_at" type="date" formater="DD/MM/YYYY" />
                    </div>
                    <div class="field">
                        <label><?=h(__('Date Export')) ?></label>
                        <calendar placeholder="Birth Date" v-model="search.date_export" type="date" formater="DD/MM/YYYY" />
                    </div>
                </div>

                <div class="fields">
                    <hr class="uk-divider-icon" />
                </div>

                <div class="fields">
                    <label>&nbsp;</label>
                    <div class="uk-position-bottom-right">
                        <div class="ui mini buttons">
                            <button class="ui button" @click="resetSearch()"><i class="redo icon"></i><?= h(__('Reset')) ?></button>
                            <div class="or"></div>
                            <button class="ui positive button" @click="getData()"><i class="search icon"></i><?= h(__('Search')) ?></button>
                            <div class="or"></div>
                            <button class="ui violet button"><i class="download icon"></i><?= h(__('Export')) ?></button>
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
                <th class="uk-table-shrink"><?= h(__('Name')) ?></th>
                <th class="uk-table-shrink"><?= h(__('Category')) ?></th>
                <th class="uk-table-shrink"><?= h(__('Image')) ?></th>
                <th class="uk-table-shrink"><?= h(__('Date Create')) ?></th>
                <th class="uk-table-shrink"><?= h(__('Date Export')) ?></th>
                <th class="uk-table-shrink"><?= h(__('Amount')) ?></th>
                <th class="uk-table-shrink"><?= h(__('Quantity Use')) ?></th>
                <th class="uk-table-shrink"><?= h(__('Quantity Inventory')) ?></th>
                <th class="uk-table-shrink">
                    <button class="uk-button uk-button-primary uk-button-small" @click="addData()"><?= h(__('Add')) ?></button>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(comd, index) in commodities">
                <td class="uk-table-shrink">{{ index + 1 }}</td>
                <td class="uk-table-shrink">{{ comd.name }}</td>
                <td class="uk-table-shrink">{{ comd.Categories.name }}</td>
                <td class="uk-table-shrink">
                    <img v-if="comd.img_path" :src="'/webroot/img/commodity/' + comd.img_path"
                        style="width: 100px; background-color: white; border: 1px solid #DDD; padding: 5px;" />
                </td>
                <td class="uk-table-shrink">{{ comd.created_at }}</td>
                <td class="uk-table-shrink">{{ comd.date_export }}</td>
                <td class="uk-table-shrink">{{ comd.amount }}</td>
                <td class="uk-table-shrink">{{ comd.quantity_use }}</td>
                <td class="uk-table-shrink">{{ comd.quantity_inventory }}</td>
                <td class="uk-table-shrink">
                    <a title="<?= h(__('Edit')) ?>" @click="editData(comd.id)" data-uk-tooltip><i class="edit icon"></i></a>
                    <a style="color:red" title="<?= h(__('Delete')) ?>" @click="deleteComfirm(comd.id)" data-uk-tooltip><i
                            class="trash alternate icon"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div>
    <ul class="uk-pagination uk-flex-right uk-margin-medium-top" uk-margin>
        <li><a href="#"><span uk-pagination-previous></span></a></li>
        <li class="uk-active" ><a href=""></a></li>
        <li><a href="#"><span uk-pagination-next></span></a></li>
    </ul>
</div>
<div class="ui modal" id="detailModal">
    <i class="close icon" style="top: 10px; right: 10px; color: black"></i>
    <div class="header">
        <?= h(__('Commodity Details')) ?>
    </div>
    <div class="content">
        <div class="ui equal width form">
            <div class="fields">
                <div class="field">
                    <label><?=h(__('Name')) ?></label>
                    <div class="ui focus input">
                        <input type="text" v-model="commodityDetail.name" placeholder="<?=h(__('Name')) ?>">
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.commodityDetail.name && !$v.commodityDetail.name.required"><?= h(__('Field is required')) ?></div>
                    <div class="ui pointing red basic label" v-if="$v.commodityDetail.name && !$v.commodityDetail.name.minLength"><?= h(__('Name at least 6 characters')) ?></div>
                    <div class="ui pointing red basic label" v-if="$v.commodityDetail.name && !$v.commodityDetail.name.maxLength"><?= h(__('Name up to 255 characters')) ?></div>
                </div>
                <div class="field">
                    <label><?=h(__('Category')) ?></label>
                    <div class="ui focus input">
                        <select class="ui fluid search dropdown" v-model="commodityDetail.category_id" id="category" >
                            <option value=""><?= h(__('Select')) ?></option>
                            <option v-for="category in categories" v-bind:data-value="category.id">{{category.name}}</option>
                        </select>
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.commodityDetail.category_id && !$v.commodityDetail.category_id.required"><?= h(__('Field is required')) ?></div>
                </div>
            </div>
            <div class="fields">
                <div class="field">
                    <label><?=h(__('Date Create')) ?></label>
                    <div>
                        <calendar v-model="commodityDetail.created_at" placeholder="<?=h(__('Date Create')) ?>" />
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.commodityDetail.created_at && !$v.commodityDetail.created_at.required"><?= h(__('Field is required')) ?></div>
                </div>
                <div class="field">
                    <label><?=h(__('Date Export')) ?></label>
                    <div>
                        <calendar v-model="commodityDetail.date_export" placeholder="<?=h(__('Date Export')) ?>" type="date" />
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.commodityDetail.date_export && !$v.commodityDetail.date_export.required"><?= h(__('Field is required')) ?></div>
                </div>
            </div>
            <div class="fields">
                <div class="field">
                    <label><?=h(__('Amount')) ?></label>
                    <div class="ui focus input">
                        <input type="text" v-model="commodityDetail.amount" placeholder="<?=h(__('Amount')) ?>">
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.commodityDetail.amount && !$v.commodityDetail.amount.required"><?= h(__('Field is required')) ?></div>
                </div>
                <div class="field">
                    <label><?=h(__('Quantity')) ?></label>
                    <div class="ui focus input">
                        <input type="text" v-model="commodityDetail.quantity" placeholder="<?= h(__('Quantity')) ?>">
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.commodityDetail.quantity && !$v.commodityDetail.quantity.required"><?= h(__('Field is required')) ?></div>
                </div>
            </div>
            <div class="fields">
                <div class="field">
                    <label><?=h(__('Quantity Use')) ?></label>
                    <div class="ui focus input">
                        <input type="text" v-model="commodityDetail.quantity_use" placeholder="<?= h(__('Quantity Use')) ?>">
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.commodityDetail.quantity_use && !$v.commodityDetail.quantity_use.required"><?= h(__('Field is required')) ?></div>
                </div>
                <div class="field">
                <label><?=h(__('Quantity Inventory')) ?></label>
                    <div class="ui focus input">
                        <input type="text" v-model="commodityDetail.quantity_inventory" placeholder="<?= h(__('Quantity Inventory')) ?>">
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.commodityDetail.quantity_inventory && !$v.commodityDetail.quantity_inventory.required"><?= h(__('Field is required')) ?></div>
                </div>
            </div>
            <div class="fields">
                <div class="field">
                    <label><?=h(__('Note')) ?></label>
                    <div class="ui focus input">
                        <textarea v-model="commodityDetail.note"></textarea>
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.commodityDetail.note && !$v.commodityDetail.note.required"><?= h(__('Field is required')) ?></div>
                </div>
                <div class="field">
                    <label><?=h(__('Image Commodity')) ?></label>
                    <div class="ui focus input">
                        <input type="file" @change="previewImg" multiple>
                    </div>
                    <label>&nbsp;</label>
                    <div class="ui focus input" v-if="imageData.length > 0 && commodityDetail.img_path">
                        <img class="preview" :src="imageData" style="width: 200px; background-color: white; border: 1px solid #DDD; padding: 5px;">
                    </div>
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
        <?= h(__('Delete User Item')) ?>
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
                search :{
                    name:'',
                    category_id:'',
                    date_export:'',
                    created_at:''
                },
                commodities: [],
                categories: [],
                commodityDetail: {
                    name:'',
                    category_id:'',
                    img_path:'',
                    date_export:'',
                    amount:'',
                    quantity:'',
                    quantity_use:'',
                    quantity_inventory:'',
                    note:'',
                    del_flg: 0,
                    created_at:'',
                    updated_at:''
                },
                imageData: '',
                comdId:'',
                action:''
            }
        },
        validations() {
            if(this.action === 'search'){
                return {
                    commodityDetail:{}
                }
            }
            if(this.action === 'savedata'){
                return {
                    commodityDetail :{
                        name: {
                            required,
                            minLength: minLength(6),
                            maxLength: maxLength(255)
                        },
                        category_id: {
                            required
                        },
                        date_export: {
                            required
                        },
                        amount: {
                            required
                        },
                        quantity: {
                            required
                        },
                        quantity_use: {
                            required
                        },
                        quantity_inventory: {
                            required
                        },
                        created_at: {
                            required
                        }
                    }
                };
            }
            return {
                commodityDetail: {}
            };
        },
        created(){

        },
        mounted(){
            this.getData();
            this.getCatName();
            $('#category_search').dropdown({
                onChange: function(value, text, $selectedItem){
                    this.search.category_id = value;
                }
            });
            $('#category').dropdown({
                onChange: function(value, text, $selectedItem){
                    // this.commodityDetail.category_id = value;
                }
            });
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
            getCatName: async function(){
                let response = await this.API('GET', 'category/list');
                if(response.status_code === '200'){
                    this.categories = response.data;
                }
            },
            async getData(){
                let response = await this.API('GET', 'commodity/list', null, this.search);
                if (response.status_code === '200') {
                    this.commodities = response.data;
                    this.showSuccessToast(response.message);
                    this.totalPage = response.totalPage;
                }
            },
            async refeshData(){
                let response = await this.API('GET', 'commodity/list');
                if (response.status_code === '200') {
                    this.commodities = response.data;
                    this.showSuccessToast(response.message);
                    this.totalPage = response.totalPage;
                }
            },
            async editData(id) {
                let response = await this.API('GET', 'commodity/get', null, {
                    id: id
                });
                if (response.status_code === '200') {
                    this.commodityDetail = response.data;
                    this.imageData = '/webroot/img/commodity/' + response.data.img_path;
                }
                $('#detailModal').modal('show');
            },
            async saveData(){
                this.action = 'savedata';
                this.$v.$touch();
                if(this.$v.$invalid){
                    return;
                };
                let response = await this.API('POST', 'commodity/save', this.commodityDetail);
                if (response.status_code === '200') {
                    this.showSuccessToast(response.message);
                    this.commodityDetail = {
                        name: '',
                        category_id:'',
                        img_path:'',
                        date_export:'',
                        amount:'',
                        quantity:'',
                        quantity_use:'',
                        quantity_inventory:'',
                        note:'',
                        created_at:''
                    };
                    this.refeshData();
                    $('#detailModal').modal('hide');
                    this.action = 'search';
                } else {
                    this.showErrorToast(response.message);
                }
            },
            deleteComfirm(id) {
                this.comdId = id;
                $('#deleteModal').modal('show');
            },
            async deleteData() {
                let response = await this.API('POST', 'commodity/delete', {
                    id: this.comdId
                });
                if (response.status_code === '200') {
                    this.showSuccessToast(response.message);
                } else {
                    this.showErrorToast(response.message);
                }
                this.refeshData();
                $('#deleteModal').modal('hide');
            },
            resetSearch() {
                this.search = {
                    name:'',
                    category_id:'',
                    created_at:'',
                    date_export:''
                }
                this.refeshData();
                this.showSuccessToast('Reset Search');
            },
            previewImg(event) {
                let input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = (e) => {
                        this.imageData = e.target.result;
                        this.commodityDetail.img_path = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            },
            close(){
                this.action = 'search';
                this.commodityDetail = {
                        name: '',
                        category_id:'',
                        img_path:'',
                        date_export:'',
                        amount:'',
                        quantity:'',
                        quantity_use:'',
                        quantity_inventory:'',
                        note:'',
                        created_at:''
                    };
                $('#detailModal').modal('hide');
            }
        }
    });
</script>
<?php $this->end(); ?>
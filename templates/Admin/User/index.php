<div class="top-page">
    <ul class="uk-breadcrumb ui dividing header">
        <li><a class="uk-link-heading section" href=""><?= h(__('Dashboard')) ?></a></li>
        <li><a class="uk-link-heading section" href=""><?= h(__('User')) ?></a></li>
    </ul>

    <ul uk-accordion="multiple: true">
        <li class="uk-open">
            <a class="uk-accordion-title" href="#"><?= h(__('Search')) ?></a>
            <div class="ui equal width form uk-accordion-content">
                <div class="fields">
                    <div class="field">
                        <label><?=h(__('Name')) ?></label>
                        <div class="ui focus input">
                            <input type="text" v-model="search.first_name" placeholder="<?=h(__('First Name')) ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label>&nbsp;</label>
                        <div class="ui focus input">
                            <input type="text" v-model="search.last_name" placeholder="<?=h(__('Last Name')) ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label><?=h(__('Phone')) ?></label>
                        <div class="ui focus input">
                            <input type="text" v-model="search.phone" placeholder="<?=h(__('Phone')) ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label><?=h(__('Address')) ?></label>
                        <div class="ui focus input">
                            <input type="text" v-model="search.address" placeholder="<?=h(__('Address')) ?>">
                        </div>
                    </div>
                </div>

                <div class="fields">
                    <div class="field">
                        <label><?=h(__('Date')) ?></label>
                        <calendar placeholder="Birth Date" v-model="search.birth_date" type="date" formater="DD/MM/YYYY" />
                    </div>
                    <div class="field">
                        <label>&nbsp;</label>
                        <div class="ui toggle checkbox">
                            <input type="checkbox" v-model="search.del_flg" true-value="1" false-value="0">
                            <label><?=h('Is deleted');?></label>
                        </div>
                    </div>
                    <div class="field"></div>
                    <div class="field"></div>
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
                <th class="uk-table-shrink"><?= h(__('Email')) ?></th>
                <th class="uk-table-shrink"><?= h(__('Phone')) ?></th>
                <th class="uk-table-shrink"><?= h(__('Address')) ?></th>
                <th class="uk-table-shrink"><?= h(__('Birthday')) ?></th>
                <th class="uk-table-shrink"><?= h(__('Avatar')) ?></th>
                <th class="uk-table-shrink">
                    <button class="uk-button uk-button-primary uk-button-small" @click="addData()"><?= h(__('Add')) ?></button>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(user, index) in users">
                <td class="uk-table-shrink">{{index+1}}</td>
                <td class="uk-table-shrink">{{user.first_name}} {{user.last_name}}</td>
                <td class="uk-table-shrink">{{user.email}}</td>
                <td class="uk-table-shrink">{{user.phone}}</td>
                <td class="uk-table-shrink">{{user.address}}</td>
                <td class="uk-table-shrink">{{user.birth_date}}</td>
                <td class="uk-table-shrink">
                    <img v-if="user.avatar_path" :src="'/webroot/img/user/' + user.avatar_path"
                        style="width: 100px; background-color: white; border: 1px solid #DDD; padding: 5px;" />
                </td>
                <td class="uk-table-shrink">
                    <a title="<?= h(__('Edit')) ?>" @click="editData(user.id)" data-uk-tooltip><i class="edit icon"></i></a>
                    <a style="color:red" title="<?= h(__('Delete')) ?>" @click="deleteComfirm(user.id)" data-uk-tooltip><i
                            class="trash alternate icon"></i></button>
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
<div class="ui modal" id="detailModal">
    <i class="close icon" @click="close()" style="top: 10px; right: 10px; color: black"></i>
    <div class="header">
        <?= h(__('User Details')) ?>
    </div>
    <div class="content">
        <div class="ui equal width form">
            <div class="fields">
                <div class="field">
                    <label><?=h(__('First Name')) ?></label>
                    <div class="ui focus input">
                        <input type="text" v-model="usersDetail.first_name" placeholder="<?=h(__('First Name')) ?>">
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.usersDetail.first_name && !$v.usersDetail.first_name.required"><?= h(__('Field is required')) ?></div>
                    <div class="ui pointing red basic label" v-if="$v.usersDetail.first_name && !$v.usersDetail.first_name.minLength"><?= h(__('Name at least 2 characters')) ?></div>
                    <div class="ui pointing red basic label" v-if="$v.usersDetail.first_name && !$v.usersDetail.first_name.maxLength"><?= h(__('Name up to 255 characters')) ?></div>
                </div>
                <div class="field">
                    <label><?=h(__('Last Name')) ?></label>
                    <div class="ui focus input">
                        <input type="text" v-model="usersDetail.last_name" placeholder="<?=h(__('Last Name')) ?>">
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.usersDetail.last_name && !$v.usersDetail.last_name.required"><?= h(__('Field is required')) ?></div>
                    <div class="ui pointing red basic label" v-if="$v.usersDetail.last_name && !$v.usersDetail.last_name.minLength"><?= h(__('Name at least 2 characters')) ?></div>
                    <div class="ui pointing red basic label" v-if="$v.usersDetail.last_name && !$v.usersDetail.last_name.maxLength"><?= h(__('Name up to 255 characters')) ?></div>
                </div>
            </div>
            <div class="fields">
                <div class="field">
                    <label><?=h(__('Code')) ?></label>
                    <div class="ui focus input">
                        <input type="text" v-model="usersDetail.account_code" placeholder="<?=h(__('Code')) ?>">
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.usersDetail.account_code && !$v.usersDetail.account_code.required"><?= h(__('Field is required')) ?></div>
                </div>
                <div class="field">
                    <label><?=h(__('Email')) ?></label>
                    <div class="ui focus input">
                        <input type="text" v-model="usersDetail.email" placeholder="<?=h(__('Email')) ?>">
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.usersDetail.email && !$v.usersDetail.email.required"><?= h(__('Field is required')) ?></div>
                </div>
            </div>
            <div class="fields">
                <div class="field">
                    <label><?=h(__('Address')) ?></label>
                    <div class="ui focus input">
                        <input type="text" v-model="usersDetail.address" placeholder="<?=h(__('Address')) ?>">
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.usersDetail.address && !$v.usersDetail.address.required"><?= h(__('Field is required')) ?></div>
                </div>
                <div class="field">
                    <label><?=h(__('Phone')) ?></label>
                    <div class="ui focus input">
                        <input type="text" v-model="usersDetail.phone" placeholder="<?= h(__('Phone')) ?>">
                    </div>
                    <div class="ui pointing red basic label" v-if="$v.usersDetail.phone && !$v.usersDetail.phone.required"><?= h(__('Field is required')) ?></div>
                </div>
            </div>
            <div class="fields">
                <div class="field">
                    <label><?=h(__('Birthday')) ?></label>
                    <calendar v-model="usersDetail.birth_date" placeholder="<?=h(__('Birthday')) ?>" type="date" />
                </div>
                <div class="field">
                    <label><?=h(__('Permission')) ?></label>
                    <div class="ui focus input">
                        <select class="ui dropdown" id="permission" v-model="usersDetail.role_type">
                            <option value=""><?= h(__('Select')) ?></option>
                            <option value="0">Quản trị viên</option>
                            <option value="1">Nhân viên</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="fields">
                <div class="field">
                    <label><?=h(__('Avatar')) ?></label>
                    <div class="ui focus input">
                        <input type="file" @change="previewImg" multiple>
                    </div>
                </div>
                <div class="field">
                    <label>&nbsp;</label>
                    <div class="ui focus input" v-if="imageData.length > 0 && usersDetail.avatar_path">
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
            search: {
                first_name:'',
                last_name:'',
                phone:'',
                address:'',
                birth_date:'',
                del_flg: 0
            },
            users: [],
            usersDetail: {
                id: '',
                first_name: '',
                last_name: '',
                account_code: '',
                birth_date: '',
                email: '',
                phone: '',
                address: '',
                avatar_path: '',
                role_type: ''
            },
            userId: '',
            totalPage: '',
            imageData: '',
            action:''
        }
    },
    validations(){
        if(this.action === 'search'){
            return {
                usersDetail:{}
            }
        }
        if(this.action === 'savedata'){
            return {
                usersDetail :{
                    first_name: {
                        required,
                        minLength: minLength(2),
                        maxLength: maxLength(255)
                    },
                    last_name: {
                        required,
                        minLength: minLength(2),
                        maxLength: maxLength(255)
                    },
                    account_code: {
                        required
                    },
                    birth_date:{
                        required
                    },
                    email: {
                        required
                    },
                    phone: {
                        required
                    },
                    address:{
                        required
                    }
                }
            };
        }
        return {
            usersDetail: {}
        };
    },
    created() {

    },
    mounted() {
        this.getData();
        $('#permission').dropdown();
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
            let response = await this.API('GET', 'users/list', null, this.search);
            if (response.status_code === '200') {
                this.users = response.data;
                this.totalPage = response.totalPage;
                this.showSuccessToast(response.message);
            }else{
                
            }
        },
        async refeshData() {
            let response = await this.API('GET', 'users/list');
            if (response.status_code === '200') {
                this.users = response.data;
            }
        },
        async editData(id) {
            let response = await this.API('GET', 'users/get', null, {
                id: id
            });
            if (response.status_code === '200') {
                this.usersDetail = response.data;
                this.imageData = '/webroot/img/user/' + response.data.avatar_path;
            }
            $('#permission').dropdown('set selected', this.usersDetail.role_type);
            $('#detailModal').modal('show');
        },
        async saveData() {
            this.action = 'savedata';
            if(this.$v.$invalid){
                return;
            };
            let response = await this.API('POST', 'users/save', this.usersDetail);
            if (response.status_code === '200') {
                this.showSuccessToast(response.message);
                this.usersDetail = {
                    first_name: '',
                    last_name: '',
                    account_code: '',
                    email: '',
                    address: '',
                    phone: '',
                    birth_date: '',
                    role_type: '',
                    avatar_path: ''
                };
                this.refeshData();
                $('#detailModal').modal('hide');
                this.action = 'search';
            } else {
                this.showErrorToast(response.message);
            }
        },
        deleteComfirm(id) {
            this.userId = id;
            $('#deleteModal').modal('show');
        },
        async deleteData() {
            let response = await this.API('POST', 'users/delete', {
                id: this.userId
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
            let response = await this.API('GET', 'users/list', null, {page:page});
            if (response.status_code === '200') {
                this.users = response.data;
                this.totalPage = response.totalPage;
            }
        },
        resetSearch() {
            this.search = {
                first_name:'',
                last_name:'',
                phone:'',
                address:'',
                birth_date:''
            }
            this.refeshData();
            this.showSuccessToast('Reset Search');
        },
        previewImg(event) {
            let input = event.target;
            // Ensure that you have a file before attempting to read it
            if (input.files && input.files[0]) {
                // create a new FileReader to read this image and convert to base64 format
                var reader = new FileReader();
                // Define a callback function to run, when FileReader finishes its job
                reader.onload = (e) => {
                    // Note: arrow function used here, so that "this.imageData" refers to the imageData of Vue component
                    // Read image as base64 and set to imageData
                    this.imageData = e.target.result;
                    this.usersDetail.avatar_path = e.target.result;
                }
                // Start the reader job - read file as a data url (base64 format)
                reader.readAsDataURL(input.files[0]);
            }
        },
        close() {
            this.usersDetail = {
                first_name: '',
                last_name: '',
                account_code: '',
                email: '',
                address: '',
                phone: '',
                birth_date: '',
                role_type: '',
                avatar_path: ''
            };
            this.imageData = '';
            $('.ui.modal').modal('hide');
            this.action = 'search';
        }
    }
});
</script>
<?php $this->end(); ?>
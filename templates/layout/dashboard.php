<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h(__($title)) ?></title>
    <?= $this->Html->meta('icon') ?>
    <!-- CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/css/uikit.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.6/dist/semantic.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3.3.2/dist/vue-loading.css">
    <!-- CSS FILES -->
    <?= $this->Html->css('uikit.min.css') ?>
    <?= $this->Html->css('dashboard.css') ?>

    <?= $this->Html->css('icon.min.css') ?>
    <style>
    .top-page a {
        font-size: 15px;
    }

    .ui.selection.dropdown {
        width: 100%;
    }
    </style>

</head>

<body>
    <div id="app" v-cloak>
        <loading :active.sync="isLoading" :can-cancel="true" :is-full-page="fullPage"></loading>
        <!--HEADER-->
        <?= $this->Html->css('semantic.min.css') ?>
        <?= $this->element('header') ?>
        <!--/HEADER-->

        <!-- LEFT BAR -->
        <?= $this->element('sidebar') ?>
        <!-- /LEFT BAR -->
        <!-- CONTENT -->
        <div id="content" data-uk-height-viewport="expand: true" style="margin-left: 0px; background-color: #ffffff">
            <div class="uk-container uk-container-expand">
                <?= $this->Flash->render() ?>

                <?= $this->fetch('content') ?>

                <?= $this->element('footer') ?>
            </div>
        </div>
    </div>
    <!-- /CONTENT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- JS FILES -->
    <!-- <?= $this->Html->script('uikit.min.js') ?> -->
    <!-- <?= $this->Html->script('uikit-icons.min.js') ?> -->
    <script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.6/dist/semantic.min.js"></script>
    <!-- CDN -->

    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/js/uikit-icons.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.15/lodash.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.24.0/moment.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/vuelidate@0.7.4/dist/vuelidate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuelidate@0.7.4/dist/validators.min.js"></script>
    <!-- VUEJS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script> -->
    <?= $this->Html->script('vue.js') ?>
    <script src="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3.3.2/dist/vue-loading.min.js"></script>

    <script>
        window.Vue.use(window.vuelidate.default);
        Vue.use(VueLoading, {
            // props
            color: '#d20505',
            loader: 'spinner'
        },{
            //slots
        });
        Vue.component('loading', VueLoading);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <?= $this->element('components/calendar') ?>
    <?= $this->Html->script('common/mixin.js') ?>
    <?= $this->fetch('scriptcontent'); ?>
</body>

</html>
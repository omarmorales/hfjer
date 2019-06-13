<template>
    <div class="container">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Reporte global</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <div class="row">
            <div class="col-md-12">
                <h3 class="font-weight-bold text-uppercase text-center">
                    <i class="fas fa-chart-bar"></i>
                    Reporte de progreso de implementacion para {{ organization.name }}
                </h3>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Seleccionar grupo de personas beneficiarias</label>
                    <select class="form-control" id="group" v-model="group_selected" @change="getBeneficiaries()">
                        <option v-for="group in groups" :key="group.id" :value="group">{{ group.name }}</option>
                    </select>
                </div>
                <div class="form-group" v-show="group_selected">
                    <label for="">Versión de la herramienta</label>
                    <input type="text" :value="group_selected.evaluation" readonly class="form-control">
                </div>
                <div class="form-group" v-show="resultsBtn">
                    <button class="btn btn-primary" @click="showData">Obtener datos</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            loading: false,
            user: '',
            organization: '',
            groups: [],
            group_selected: '',
            resultsBtn: false,
            beneficiaries: [],
            beneficiaries_evaluations: [],
        }),
        methods:{
            showData(){
                
            },
            getBeneficiaries(){
                if (this.group_selected) {
                    this.resultsBtn = true
                    this.beneficiaries = this.group_selected.beneficiaries.filter(beneficiary => beneficiary.birthdate !== null)
                }else {
                    this.resultsBtn = false;
                }
            },
            loadUser(){
                this.$Progress.start();
                this.loading = true;
                axios.get("api/profile").then(({ data }) => (
                    this.user = data,
                    this.organization = data.organization,
                    this.groups = data.organization.groups,
                    this.$Progress.finish(),
                    this.loading = false
                )).catch(() => {
                    this.loading = false;
                    this.$Progress.fail();
                });
            }
        },
        created(){
            this.loadUser();
        }
    }
</script>

<style lang="scss" scoped>

</style>
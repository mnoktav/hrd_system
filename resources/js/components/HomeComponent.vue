<template>
    <div class="">
        <div class="row justify-content-center my-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Data Karyawan</div>

                    <div class="card-body">
                        <div class="my-2">
                            <router-link :to="{name: 'create'}" class="btn btn-success">Add Employee</router-link>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>Jabatan</th>
                                    <th>Divisi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{ user.id }}</td>
                                    <td>{{ user.first_name }}</td>
                                    <td>{{ user.position }}</td>
                                    <td>{{ user.division }}</td>
                                    <td>
                                        <router-link class="btn btn-warning">
                                            Edit
                                        </router-link>
                                        <button class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
   export default {
      data() {
        return {
            users: []
        }
      },
        created() {
        let uri = 'http://127.0.0.1:8000/api/users';
        this.axios.get(uri).then(response => {
            this.users = response.data.data;
        });
    }
  }
</script>

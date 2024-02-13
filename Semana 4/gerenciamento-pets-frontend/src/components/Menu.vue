<template>
  <v-navigation-drawer permanent>
    <v-list>
      <v-list-item
        prepend-avatar="https://randomuser.me/api/portraits/women/85.jpg"
        title="Caroline Sampaio"
        subtitle="carol@gmail.com"
      ></v-list-item>
    </v-list>

    <v-divider></v-divider>

    <v-list density="compact" nav>
      <router-link to="/home">
        <v-list-item prepend-icon="mdi-folder" title="Home" value="myfiles"> </v-list-item>
      </router-link>

      <router-link to="/pets/novo">
        <v-list-item prepend-icon="mdi-star" title="Novo pet" value="starred"> </v-list-item>
      </router-link>

      <router-link to="/veterinarios" v-if="permissions.includes('get-professionals')">
        <v-list-item prepend-icon="mdi-star" title="Profissionais" value="starred"> </v-list-item>
      </router-link>

      <router-link to="/usuarios" v-if="permissions.includes('create-users')">
        <v-list-item prepend-icon="mdi-account" title="Usuários" value="starred"> </v-list-item>
      </router-link>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
export default {
  data() {
    return {
      permissions: JSON.parse(localStorage.getItem('@permissions_petshop'))
    }
  }
}
</script>

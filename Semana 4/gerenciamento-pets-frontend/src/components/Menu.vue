<template>
  <v-navigation-drawer permanent>
    <v-list>
      <v-list-item
        prepend-avatar="https://randomuser.me/api/portraits/women/85.jpg"
        :title="name"
        :subtitle="profile"
      ></v-list-item>
    </v-list>

    <v-divider></v-divider>

    <v-list density="compact" nav>
      <router-link to="/home">
        <v-list-item prepend-icon="mdi-folder" title="Home" value="home"> </v-list-item>
      </router-link>

      <router-link to="/pets/novo">
        <v-list-item prepend-icon="mdi-star" title="Novo pet" value="pets"> </v-list-item>
      </router-link>

      <router-link to="/veterinarios" v-if="permissions.includes('get-professionals')">
        <v-list-item prepend-icon="mdi-star" title="Profissionais" value="professionals">
        </v-list-item>
      </router-link>

      <router-link to="/usuarios" v-if="permissions.includes('create-users')">
        <v-list-item prepend-icon="mdi-account" title="Usuários" value="users"> </v-list-item>
      </router-link>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
export default {
  data() {
    return {
      permissions: JSON.parse(localStorage.getItem('@permissions_petshop')),
      name: JSON.parse(localStorage.getItem('@name')),
      profile: JSON.parse(localStorage.getItem('@profile'))
    }
  }
}
</script>

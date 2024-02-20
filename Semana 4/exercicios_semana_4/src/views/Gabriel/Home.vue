<template>
  <div class="content">
    <div class="left-content">
      <h1 class="title">ME LEVE PARA CASA</h1>
      <p class="text">
        Nós cuidamos deles. <span class="highlighted"> Agora deixe que eles cuidem de você.</span>
      </p>
      <p class="text">
        Aqui a gente cuida de animais resgatados de áreas evacuadas de Minas Gerais e queremos
        compartilhar todo esse amor com mais pessoas por meio da adoção.
      </p>
      <p class="text">
        Ter um animal de estimação traz benefícios para a saúde física e mental. É uma troca de amor
        e carinho que faz bem pra todo mundo. Leve um para casa: cuide dele e deixe que ele cuide de
        você também.
      </p>
      <router-link to="pets-adocao">
        <button class="action">Adotar agora!</button>
      </router-link>
    </div>
    <div class="right-content">
      <img
        src="https://vale.com/documents/d/guest/imagem-dogs01?doAsUserId=RPhnXhXIUPuTnXbIjnHTCg%3D%3D%2F-%2Fcategories%2F64940%2F-%2Fcategories%2F%2F-%2Fcategories%2F64940%2F-%2Fcategories%2F%2F-%2Fcategories%2F%2F-%2Fcategories%2F64940%2F-%2Fcategories%2F%2F-%2Fcategories%2F%2F-%2Fcategories%2F%2F-%2Fcategories%2F64940%2F-%2Fcategories%2F64940%2F-%2Fcategories%2F%2F-%2Fcategories%2F%2F-%2Fcategories%2F"
        class="content-image"
      />
    </div>
  </div>
</template>
<style scoped>
.title {
  font-size: 28px;
  color: coral;
}
.content {
  display: flex;
  width: 70%;
  margin: 0 auto;
  align-items: center;
}

.text {
  font-size: 16px;
  text-align: justify;
}

.highlighted {
  font-weight: bold;
}

.content-image {
  width: 300px;
}

@media (max-width: 1000px) {
  .content {
    flex-direction: column;
  }
}

.action {
  width: 100px;
  height: 30px;
  color: white;
  background-color: coral;
  border-radius: 10px;
}
</style>

<template>
  <div>
    <b-container>
      <b-row class="justify-content-md-center mt-4">
        <b-col col md="8">
          <b-carousel
            id="carousel-1"
            v-model="slide"
            :interval="3000"
            controls
            indicators
            img-width="1024"
            img-height="480"
            style="text-shadow: 1px 1px 2px #333;"
            @sliding-start="onSlideStart"
            @sliding-end="onSlideEnd"
          >
            <div v-for="file in movie.files" :key="file.id">
              <b-carousel-slide :text="file.name" :img-src="file.url"></b-carousel-slide>
            </div>
          </b-carousel>

          <div class='mt-4'>
            <b-jumbotron>
              <template #header>
                {{movie.name}}
                <div class="mb-4 badge-category">
                  <b-badge
                    v-for="category in movie.categories"
                    :key="category.slug"
                    variant="primary"
                    class="mr-2"
                  >{{category.name}}</b-badge>
                </div>
              </template>
              <template #lead>{{movie.description}}</template>

              <hr class="my-4" />

              <p>IMDB Rating: {{movie.imdb_score}}/10 • Movie Released Date: {{movie.release_date}}</p>

              <b-button variant="primary" href="#">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-pencil"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"
                  />
                </svg>
                update the Movie
              </b-button>
              <b-button variant="danger" href="#">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-trash-fill"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"
                  />
                </svg>
                Delete the movie
              </b-button>
            </b-jumbotron>
          </div>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      slide: 0,
      sliding: null,
      movie: {
        files: [],
        categories: []
      }
    };
  },
  mounted() {
    axios.get("http://127.0.0.1:8000/api/movie/9").then(({ data }) => {
      this.movie = data;
      if (this.movie.release_date) {
        const date = new Date(this.movie.release_date);
        this.movie.release_date = `${date.getDate()}, ${date.toLocaleString(
          "default",
          { month: "long" }
        )}, ${date.getFullYear()}`;
      }
      if (this.movie.files && this.movie.files.length > 0) {
        this.movie.files.map(file => {
          if (file.url) {
            file.url = `images/${file.url}`;
          }
          return file;
        });
      }
    });
  },
  methods: {
    onSlideStart(slide) {
      this.sliding = true;
    },
    onSlideEnd(slide) {
      this.sliding = false;
    }
  }
};
</script>
<style scoped>
    .badge-category {
        font-size: 1rem;
    }
</style>
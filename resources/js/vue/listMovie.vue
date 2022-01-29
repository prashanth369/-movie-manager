<template>
  <div>
    <b-container>
      <b-row class="justify-content-md-center mt-4">
        <b-card
          v-for="movie in movies"
          :key="movie.id"
          :title="movie.title"
          :sub-title="movie.imdb_score"
          :img-src="movie.files[0].url"
          :img-alt="movie.files[0].title"
          img-top
          tag="article"
          style="max-width: 20rem;"
          class="mb-2 ml-4 mt-4"
        >
          <b-card-text class="card-text">{{movie.description}}</b-card-text>

          <b-button href="#" variant="primary">View Full details here</b-button>
        </b-card>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      movies: []
    };
  },
  mounted() {
    axios.get("http://127.0.0.1:8000/api/movies").then(({ data }) => {
      this.movies = data;

      this.movies.map(movie => {
        if (movie.description.length > 110) {
          movie.description = `${movie.description.substring(0, 110)}...`;
        }

        if (movie.imdb_score) {
          movie.imdb_score = `IMDB scre is: ${movie.imdb_score}`;
        }

        if (movie.files && movie.files.length > 0) {
          movie.files.map(file => {
            if (file.url) {
              file.url = `images/${file.url}`;
            }

            return file;
          });
        }

        return movie;
      });
    });
  }
};
</script>
<template>
  <div>
    <b-container>
      <b-row class="justify-content-md-center mt-4">
        <b-col col md="8">
          <b-card header="Add a new Movie Form" header-bg-variant="primary" header-text-variant="white">
            <b-card-text>
              <b-form @submit="onSubmit">
                <b-form-group label="Enter the name of the movie">
                  <b-form-input placeholder="Titanic" v-model="movie_name" required></b-form-input>
                </b-form-group>

                <b-form-group label="Enter the descrition of the movie" class="mt-4">
                  <b-form-textarea
                    placeholder="84 years later, a 100 year-old woman named Rose DeWitt Bukater tells"
                    v-model="movie_description"
                    rows="3"
                    max-rows="6"
                    required
                  ></b-form-textarea>
                </b-form-group>

                <b-form-group
                  label="Upload the images for the Movie (You can select multiple files at the same time)"
                >
                  <b-form-file
                    v-model="files"
                    accept="image/*"
                    multiple
                    placeholder="Choose a file or drop it here..."
                    drop-placeholder="Drop file here..."
                  ></b-form-file>
                </b-form-group>

                <b-form-group
                  label="Select all the genre of the movie"
                  v-slot="{ ariaDescribedby }"
                >
                  <b-form-checkbox-group
                    v-model="selected_categories"
                    :options="categories"
                    :aria-describedby="ariaDescribedby"
                    name="movie_categories"
                    class="form-categories"
                  ></b-form-checkbox-group>
                </b-form-group>
                <b-form-group label="Select the Release date of the movie">
                  <b-form-datepicker v-model="movie_release_date" class="mb-2"></b-form-datepicker>
                </b-form-group>

                <b-form-group>
                  <b-button variant="outline-primary" type="submit">Submit</b-button>
                </b-form-group>
              </b-form>
            </b-card-text>
          </b-card>
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
      categories: [],
      files: [],
      movie_name: "",
      movie_description: "",
      selected_categories: [],
      movie_release_date: null
    };
  },
  mounted() {
    axios.get("http://127.0.0.1:8000/api/movie/categories").then(({ data }) => {
      this.categories = data.map(item => {
        return {
          value: item.slug,
          text: item.name
        };
      });
    });
  },
  methods: {
    onSubmit(event) {
      event.preventDefault();
      console.log(
        this.files.map(f => f.name),
        this.movie_name,
        this.movie_description,
        this.movie_release_date,
        this.selected_categories
      );
    }
  }
};
</script>
<style scoped>
.form-categories {
  border: 1px solid #ced4da;
  padding: 10px;
  border-radius: 0.25rem;
}
</style>
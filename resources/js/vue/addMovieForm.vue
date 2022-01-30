<template>
  <div>
    <b-container>
      <b-row class="justify-content-md-center mt-4">
        <b-col col md="8">
          <b-card
            header="Add a new Movie Form"
            header-bg-variant="primary"
            header-text-variant="white"
          >
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
                <b-form-group label="Enter the IMDB Rating for this movie">
                  <b-form-input placeholder="9.9" v-model="imdb_score" required></b-form-input>
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
                  <div v-if="selected_file_names">{{selected_file_names.join(', ')}}</div>
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
                  <b-form-datepicker required v-model="movie_release_date" class="mb-2"></b-form-datepicker>
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
      movie_id: "",
      categories: [],
      files: [],
      movie_name: "",
      imdb_score: "",
      movie_description: "",
      selected_categories: [],
      movie_release_date: null,
      selected_file_names: []
    };
  },
  mounted() {
    const slug = window.location.href.substring(
      window.location.href.lastIndexOf("/") + 1
    );

    if (!isNaN(slug)) {
      this.movie_id = slug;
    }

    if (this.movie_id) {
      axios
        .get(`http://127.0.0.1:8000/api/movies/${this.movie_id}`)
        .then(({ data }) => {
          if (data.status !== "success") {
            window.location = "/#/";
          }
          const {
            name,
            categories,
            description,
            files,
            imdb_score,
            release_date
          } = data;
          if (data && data.status === "success") {
            this.movie_name = name;
            this.selected_file_names = files.map(file => file.url);
            this.movie_description = description;
            this.selected_categories = categories.map(item => item.slug);
            this.imdb_score = imdb_score;
            this.movie_release_date = release_date;
          }
        });
    }

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

      //field validations
      this.movie_name = this.movie_name.trim();
      this.movie_description = this.movie_description.trim();

      if (!this.movie_name || this.movie_name.length <= 2) {
        alert("Please enter valid Movie Name ");
        return;
      }

      if (!this.movie_description || this.movie_description.length <= 10) {
        alert("Please enter valid Movie Description ");
        return;
      }

      if (
        this.imdb_score &&
        this.imdb_score > 0 &&
        this.imdb_score <= 10 &&
        /^(\d{1,5}|\d{0,5}\.\d{1,2})$/.test(this.imdb_score)
      ) {
        this.imdb_score = Number(this.imdb_score).toFixed(1);
      } else {
        alert("Please enter valid IMDB score ");
        return;
      }
      if (!this.files[0]) {
        if (
          !this.selected_file_names ||
          this.selected_file_names.length === 0
        ) {
          alert("Please Upload an image of the movie");
          return;
        }
      }
      if (!this.selected_categories || this.selected_categories.length === 0) {
        alert("PleaseSelect Genre of the Movie");
        return;
      }

      if (!this.movie_release_date) {
        alert("Please select movie release year");
        return;
      }

      const formdata = new FormData();
      formdata.append("name", this.movie_name.trim());
      formdata.append("movie_id", this.movie_id);
      formdata.append("imdb_score", this.imdb_score || "0.0");
      formdata.append("release_date", this.movie_release_date);
      formdata.append("description", this.movie_description);
      formdata.append("categories", this.selected_categories);
      formdata.append("existing_files", this.selected_file_names);

      if (this.files[0]) {
        formdata.append("image", this.files[0]);
      }

      axios
        .post("http://127.0.0.1:8000/api/movie/add", formdata, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(({ data }) => {
          if (data.status === "success") {
            const errorToaster = {
              title: "Success",
              toaster: "b-toaster-bottom-center",
              variant: "success",
              noAutoHide: true
            };
            this.$root.$bvToast.toast(data.message, errorToaster);

            window.location = "/#/";
          } else {
            alert("Something went wrong!, movie couldnot be added/modified");
          }
        });
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
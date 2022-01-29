<template>
<div>
  <section class="section-preview">
      
              <div class="input-group my-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
              </div>
      
            </section>
</div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      categories: null,
      file1: null
    };
  },
  mounted() {
    axios
      .get("http://127.0.0.1:8000/api/movie/categories")
      .then(({ data }) => (this.categories = data));
  }
};
</script>
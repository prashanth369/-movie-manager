<template>
    <div class="movie-manager-container" >
        <list-movie />
    </div>
</template>

<script>
    import addMovieForm from './addMovieForm'
    import listMovie from './listMovie'
    export default {
        components: {
            listMovie
        }
    }
</script>
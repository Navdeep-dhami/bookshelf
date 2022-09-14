<template>
  <Head title="New Book" />

  <header class="container fixed-top position-relative">
    <div class="row">
      <div class="col-12">
        <div class="d-flex justify-content-end mb-3">
            <Link
            :href="route('home')"
            class="ms-4 text-muted badge p-3"
            >Book List</Link>
            <button
              v-if="$page.props.auth.user"
              @click="logout" as="button"
              class="text-muted badge bg-white p-3 ms-4"
            >
              Log Out
            </button>
        </div>
      </div>

    </div>

</header>
<section>
    <div class="container">
        <div class="row" >
            <div class="col-12">

            <div class="card-body">

            <breeze-validation-errors class="mb-3" />

            <form @submit.prevent="submit">
            <div class="mb-3">
                <breeze-label for="title" value="title" />
                <breeze-input id="title" type="text" v-model="form.title" required autofocus autocomplete="title" />
            </div>

            <div class="mb-3">
                <breeze-label for="genre" value="Genre" />
                <breeze-input id="genre" type="text" v-model="form.genre" required />
            </div>

            <div class="mb-3">
                <breeze-label for="author" value="Author" />
                <breeze-input id="author" type="text" v-model="form.author" required />
            </div>

            <div class="mb-3">
                <breeze-label for="isbn" value="ISBN" />
                <breeze-input id="isbn" type="text" v-model="form.isbn" required />
            </div>

            <div class="mb-3">
                <breeze-label for="publisher" value="Publisher" />
                <breeze-input id="publisher" type="text" v-model="form.publisher" required />
            </div>

            <div class="mb-3">
                <breeze-label for="image" value="Image Path" />
                <breeze-input id="image" type="text" v-model="form.image" required />
            </div>

            <div class="mb-3">
                <breeze-label for="published" value="Published" />
                <breeze-input id="published" type="date" v-model="form.published" required />
            </div>

            <div class="mb-3">
                <breeze-label for="description" value="Description" />
                <textarea id="description" class="d-block w-100" v-model="form.description"></textarea>
            </div>

            <div class="mb-0">
                <div class="d-flex justify-content-end align-items-baseline">


                <breeze-button class="ms-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                    </div>

                    Save
                </breeze-button>
                </div>
            </div>
            </form>
            </div>

            </div>
            <div class="col-12" v-if="showMessage">
                <div class="alert alert-success" role="alert">
                Data Saved!
                </div>
            </div>
        </div>
    </div>
</section>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue"
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'

export default {

    components: {
    Head,
    BreezeButton,
    BreezeCheckbox,
    BreezeInput,
    BreezeLabel,
    BreezeValidationErrors,
    Link,
  },

  props: {
    book: Object,
  },
  data() {
    return {
        form: this.$inertia.form({
            title: '',
            genre: '',
            author: '',
            isbn: '',
            publisher: '',
            published: '',
            description: '',
            image: '',
        }),
        showMessage: false,
    }
  },
  methods: {
    logout() {
      this.$inertia.post(route("logout"));
    },
    submit() {
        let url = this.route('books.store');
        let method = "post";
        if(this.book.author != undefined)
        {
            method = "put";
            url = this.route('books.update',{'book':this.book});
        }
      this.form.submit(method,url, {
        onSuccess: () => {
            this.successMessage();
        }
      })
    },
    successMessage: function(){
        this.showMessage = true;
      setTimeout(() => {
        this.showMessage = false;
      }, 1500)
      this.form.reset();
    }
  },
  mounted(){
    if(this.book.author != undefined)
    {
        this.form.title         =  this.book.title;
        this.form.author        = this.book.author.name;
        this.form.isbn          = this.book.isbn;
        this.form.publisher     = this.book.publisher.name;
        this.form.published     = this.book.published;
        this.form.description   = this.book.description;
        this.form.image         = this.book.image;
        this.form.genre         = this.book.genre.name;
    }
  }
};
</script>

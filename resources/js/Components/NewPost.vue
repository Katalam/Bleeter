<script setup>
import {nextTick, ref} from 'vue';
import {useForm} from "@inertiajs/inertia-vue3";
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextArea from "@/Components/TextArea.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const openingNewPost = ref(false);
const bodyInput = ref(null);
const imageInput = ref(null);

const form = useForm({
    body: '',
    image: null,
});

const newPost = () => {
    openingNewPost.value = true;

    nextTick(() => bodyInput.value.focus());
};

const closeModal = () => {
    openingNewPost.value = false;

    form.reset();
};

const submitPost = () => {
    form.post(route('posts.store'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => bodyInput.value.focus(),
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <button class="ml-4 px-4 py-2 rounded-lg bg-green-400 text-white font-semibold tracking-wide select-none"
            @click="newPost">
        New Post
    </button>
    <Modal :show="openingNewPost" @close="closeModal">
        <form @submit.prevent="submitPost">
            <div class="p-6 space-y-6">
                <div>
                    <InputLabel for="bodyInput" value="Life suddenly got quick!"/>

                    <TextArea
                        id="bodyInput"
                        ref="bodyInput"
                        v-model="form.body"
                        type="password"
                        class="mt-1 block w-full"
                        placeholder="What's on your mind?"
                        @keyup.enter="submitPost"
                    />

                    <InputError :message="form.errors.password" class="mt-2"/>
                </div>
                <div>
                    <input type="file" @input="form.image = $event.target.files[0]" class="hidden" ref="imageInput" />
                    <div class="w-full rounded-lg shadow-sm h-8 flex justify-center border text-neutral-500 hover:border-2 hover:border-green-500 items-center" @click="$refs.imageInput.click()" v-if="!form.image">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <div class="w-full rounded-lg shadow-sm h-8 flex justify-center border text-neutral-500 hover:border-2 hover:border-green-500 items-center" @click="$refs.imageInput.click()" v-if="form.image" v-text="form.image.name">
                    </div>
                    <div class="w-full flex items-center justify-center text-neutral-500 hover:text-neutral-700 cursor-pointer mt-2" v-if="form.image" @click="form.image = null">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </div>

                    <InputError :message="form.errors.image" class="mt-2"/>
                </div>
                <div class="flex justify-end">
                    <SecondaryButton @click="closeModal">Cancel</SecondaryButton>

                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="submitPost"
                    >
                        Bleat It!
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>

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

const form = useForm({
    body: '',
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
        <div class="p-6">
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
            <div class="mt-6 flex justify-end">
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
    </Modal>
</template>

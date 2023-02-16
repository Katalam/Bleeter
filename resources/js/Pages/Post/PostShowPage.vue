<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import Post from "@/Pages/Post/Post.vue";
import WhoToFollow from "@/Components/WhoToFollow.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextArea from "@/Components/TextArea.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Inertia} from "@inertiajs/inertia";
import {ref} from "vue";

const props = defineProps({
    post: {
        type: Object,
        required: true
    },
    users: {
        type: Array,
        required: true
    },
})

const bodyInput = ref(null);

const form = useForm({
    body: '',
    parent_id: props.post.id,
});

const submitPost = () => {
    form.post(route('posts.store'), {
        preserveScroll: true,
        onSuccess: () =>
            Inertia.reload({
                preserveState: true,
                preserveScroll: true,
                only: ['post'],
            })
,
        onError: () => bodyInput.value.focus(),
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Post"/>

    <AuthenticatedLayout>
        <template #header>
            <h1>Post</h1>
        </template>
        <template #sidebar>
            <WhoToFollow :users="users"/>
        </template>

        <div class="space-y-4">
            <Post :post="post"/>
            <div class="grid grid-cols-7 pb-2">
                <div class="border-r-4 mx-auto my-6"></div>
                <div class="col-span-6 space-y-4">
                    <Post :post="answer" v-for="answer in post.answers" :key="answer.id"/>
                </div>
                <div class="col-span-7 mt-10 mx-1">
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
            </div>
        </div>
    </AuthenticatedLayout>
</template>

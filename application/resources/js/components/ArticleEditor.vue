<template>
    <div class="article-wrapper">
        <h2 class="load-error" v-show="articleError">{{ articleErrorMessage }}</h2>
        <article class="article-editor">
            <form @submit.prevent="onSubmit">
                <div class="editor-form-group" :class="{ 'editor-title-error': v$.article.title.$errors.length }">
                    <label for="title-edit" class="title-label">Title</label>
                    <span
                        class="editor-field-error"
                        v-for="(error, index) of v$.article.title.$errors"
                        :key="index"
                    >
                        {{ error.$message }}
                    </span>
                    <input id="title-edit" class="title-edit" type="text" name="title" v-model="article.title">
                </div>
                <div class="editor-form-group" :class="{ 'editor-body-error': v$.article.body.$errors.length }">
                    <label for="body-edit" class="body-label">Body</label>
                    <span
                        class="editor-field-error"
                        v-for="(error, index) of v$.article.body.$errors"
                        :key="index"
                    >
                        {{ error.$message }}
                    </span>
                    <textarea id="body-edit" class="body-edit" v-model="article.body" rows="10"></textarea>
                </div>
                <div class="editor-form-group">
                    <button
                        class="save-article"
                        type="submit"
                        :disabled="!canSubmit()"
                    >
                        Save article
                    </button>
                </div>
            </form>
        </article>
    </div>
</template>

<script>
import {required, minLength, maxLength} from '@vuelidate/validators'
import useValidate from "@vuelidate/core";

export default {
    name: "ArticleEditor",
    data: function () {
        return {
            v$: useValidate(),
        }
    },
    props: {
        article: {
            "type": Object,
            "required": true,
        },
        articleError: {
            "type": Boolean,
            "required": true,
        },
        articleErrorMessage: {
            "type": String,
            "required": true,
        },
        isArticleDirty: {
            "type": Boolean,
            "required": true,
        },
        isArticleUpdating: {
            "type": Boolean,
            "required": true,
        },
    },
    methods: {
        onSubmit() {
            if (this.canSubmit()) {
                this.v$.$validate()
                if (!this.v$.$error) {
                    this.$emit('update-article', this.article)
                    this.v$.$reset()
                } else {
                    // validation failed
                }
            } else {
            }
        },
        canSubmit() {
            return !(!(this.isArticleDirty) || (this.isArticleUpdating))
        }
    },
    watch: {
        article: {
            handler(newVal, oldVal) {
                if (Object.keys(oldVal).length > 0 && Object.keys(newVal).length > 0) {
                    this.$emit('set-article-dirty', true)
                }
            },
            deep: true
        }
    },
    validations() {
        return {
            article: {
                title: {
                    required,
                    min: minLength(3),
                    max: maxLength(255),
                },
                body: {
                    required,
                    min: minLength(3),
                    max: maxLength(2000),
                },
            },
        }
    },
}
</script>

<style scoped>

</style>

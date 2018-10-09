<template>
    <default-field :field="field" :errors="errors" :fullWidthContent="true">
        <template slot="field">
            <editor :extensions="extensions" @update="editorUpdated" ref="editor">
                <div slot="menubar" slot-scope="{ nodes, marks }">
                    <div class="tiptap-menu">
                        <div v-if="nodes || marks">
                            <template v-if="nodes.heading">
                                <button
                                    v-for="level in headingLevels"
                                    type="button"
                                    class="
                                        btn
                                        btn-default
                                        p-2
                                        leading-none
                                        text-xs
                                        min-w-8
                                        h-8
                                        tiptap-button
                                    "
                                    :class="{ 'btn-primary': nodes.heading.active({ level: level }) }"
                                    @click="nodes.heading.command({ level: level })"
                                >
                                  H{{  level  }}
                                </button>
                            </template>

                            <template v-for="(nodeButtonExtension, nodeButtonKey) in nodeButtons">
                                <button
                                    v-if="nodes[nodeButtonKey]"
                                    type="button"
                                    class="
                                        btn
                                        btn-default
                                        p-2
                                        leading-none
                                        text-xs
                                        min-w-8
                                        h-8
                                        tiptap-button
                                    "
                                    :class="{ 'btn-primary': nodes[nodeButtonKey].active() }"
                                    @click="nodes[nodeButtonKey].command()">
                                    <font-awesome-icon v-if="nodeButtonKey == 'bullet_list'" :icon="['far', 'list-ul']">
                                    </font-awesome-icon>

                                    <font-awesome-icon v-if="nodeButtonKey == 'ordered_list'" :icon="['far', 'list-ol']">
                                    </font-awesome-icon>

                                    <font-awesome-icon v-if="nodeButtonKey == 'blockquote'" :icon="['far', 'quote-right']">
                                    </font-awesome-icon>

                                    <template v-if="nodeButtonKey == 'code_block'">
                                        &lt;/&gt;
                                    </template>
                                </button>
                            </template>

                            <template v-for="(markButtonExtension, markButtonKey) in markButtons">
                                <button
                                    v-if="marks[markButtonKey]"
                                    type="button"
                                    class="
                                        btn
                                        btn-default
                                        p-2
                                        leading-none
                                        text-xs
                                        min-w-8
                                        h-8
                                        tiptap-button
                                    "

                                    :class="[
                                        marks[markButtonKey].active() ? 'btn-primary' : '',
                                        'is-' + markButtonKey
                                    ]"

                                    @click="marks[markButtonKey].command()">



                                </button>
                            </template>

                            <span class="tiptap-button-container" v-if="marks.link">
                                <form
                                    class="
                                        tiptap-button-form
                                        btn
                                        btn-default
                                        p-2
                                    "
                                    v-if="linkMenuIsActive"
                                    @submit.prevent="setLinkUrl(linkUrl, marks.link)"
                                >
                                    <input
                                        class="
                                            form-input
                                            form-input-bordered
                                            p-1
                                            text-xs
                                            leading-none
                                        "
                                        placeholder="enter URL"
                                        type="text"
                                        v-model="linkUrl"
                                        ref="linkInput"
                                        @keydown.esc="hideLinkMenu"
                                    >

                                    <button
                                        class="btn is-close"
                                        @click="setLinkUrl(null, marks.link)"
                                        type="button"
                                    >
                                        <font-awesome-icon :icon="['far', 'times-circle']">
                                        </font-awesome-icon>
                                    </button>
                                </form>


                                <button
                                    class="
                                    js-keep-selection-button
                                    btn
                                    btn-default
                                    p-2
                                    leading-none
                                    text-xs
                                    min-w-8
                                    h-8
                                    tiptap-button
                                    "
                                    type="button"
                                    @click="showLinkMenu(marks.link)"
                                    :class="{ 'is-active': marks.link.active() }"
                                >
                                    <font-awesome-icon :icon="['far', 'link']"></font-awesome-icon>
                                </button>

                                <button
                                    class="
                                    btn
                                    btn-default
                                    p-2
                                    leading-none
                                    text-xs
                                    min-w-8
                                    h-8
                                    tiptap-button
                                    "
                                    type="button"
                                    @click="setLinkUrl(null, marks.link)"
                                    :class="{ 'is-active': marks.link.active() }"
                                >
                                    <font-awesome-icon :icon="['far', 'unlink']"></font-awesome-icon>
                                </button>


                            </span>
                        </div>
                    </div>
                </div>

                <div
                    class="
                    tiptap-content
                    py-3 h-auto
                    w-full
                    form-control
                    form-input
                    form-input-bordered
                    mt-2
                    no-focus
                    "
                    slot="content"
                    slot-scope="props"
                >

                </div>
            </editor>
        </template>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

import { library } from '@fortawesome/fontawesome-svg-core'
import { faLink, faUnlink, faCode, faTimesCircle, faListUl, faListOl, faQuoteRight } from '@fortawesome/pro-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faLink, faUnlink, faCode, faTimesCircle, faListUl, faListOl, faQuoteRight)

import { Editor } from 'tiptap'
import {
  // Nodes
  BlockquoteNode,
  BulletListNode,
  CodeBlockNode,
  CodeBlockHighlightNode,
  HardBreakNode,
  HeadingNode,
  ImageNode,
  ListItemNode,
  OrderedListNode,
  TodoItemNode,
  TodoListNode,

  // Marks
  BoldMark,
  CodeMark,
  ItalicMark,
  LinkMark,
  StrikeMark,
  UnderlineMark,

  // General Extensions
  HistoryExtension,
  PlaceholderExtension,
} from 'tiptap-extensions'

import { default as InsMark } from './marks/InsMark.js'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    components: {
        Editor,
        FontAwesomeIcon,
    },

    data: function () {
        return {
            headingLevels: 3,

            markButtons: {
                'bold': new BoldMark(),
                'italic': new ItalicMark(),
                'code': new CodeMark(),
                'strike': new StrikeMark(),
                'underline': new UnderlineMark(),
            },

            nodeButtons: {
                'code_block': new CodeBlockNode(),
                'bullet_list': new BulletListNode(),
                'ordered_list': new OrderedListNode(),
                'blockquote': new BlockquoteNode(),
            },

            linkUrl: null,

            linkMenuIsActive: false,
        }
    },

    computed: {
        extensions() {
            let extensions = [
                new HistoryExtension(),
                new PlaceholderExtension(),
                new HardBreakNode(),
                new ListItemNode(),
                new InsMark(),
            ];

            let buttons = this.field.buttons ? this.field.buttons : ['bold', 'italic'];

            _.forEach(this.markButtons, function(extension, name) {
                if (_.includes(buttons, name)) {
                    extensions.push(extension);
                }
            }.bind(this));

            _.forEach(this.nodeButtons, function(extension, name) {
                if (_.includes(buttons, name)) {
                    extensions.push(extension);
                }
            }.bind(this));

            _.forEach(buttons, function(params, key) {
                if (key == 'heading') {
                    extensions.push(new HeadingNode({ maxLevel: params }));
                    this.headingLevels = params;
                }

                if (params == 'heading') {
                    extensions.push(new HeadingNode({ maxLevel: this.headingLevels }));
                }

                if (params == 'link') {
                    extensions.push(new LinkMark());
                }

            }.bind(this));

            return extensions;
        }
    },

    methods: {
        setInitialValue() {
            this.value = this.field.value || ''
        },

        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        },

        handleChange(value) {
            this.value = value
        },

        editorUpdated(state) {
            this.handleChange(state.getHTML());
        },

        populateEditor() {
            this.$refs.editor.setContent(this.value);
        },

        showLinkMenu(type) {
            this.linkUrl = type.attrs.href
            this.linkMenuIsActive = true
            this.$nextTick(() => {
                this.$refs.linkInput.focus()
            })
        },

        hideLinkMenu() {
            this.linkUrl = null
            this.linkMenuIsActive = false
        },

        removeFauxHighlights() {
            var wrap = $('.ProseMirror').find('ins');
            var text = wrap.html();
            wrap.replaceWith(text);
        },

        setLinkUrl(url, type, focus) {
            type.command({ href: url })
            this.hideLinkMenu()
            this.removeFauxHighlights()
        },

    },

    mounted: function () {
        this.populateEditor();
    }
}
</script>

<style>
.tiptap-content {
    outline: none !important;
    box-shadow: none !important;
}

.ProseMirror:focus {
    outline: none;
}

.ProseMirror ins {
    text-decoration: none;
    background-color: highlight;
}

.ProseMirror p {
    margin-bottom: 1em;
}

.ProseMirror p:last-child {
    margin-bottom: 0;
}

.tiptap-button {
    box-sizing: border-box;
    vertical-align: top;
    margin-right: 8px;
    font-weight: 400;
}

.tiptap-button-container {
    position: relative;
    overflow: visible;
}

.tiptap-button-form {
    position: absolute;
    top: 36px;
    left: -130px;
    display: flex;
    background-color: white;
    align-items: center;
}

.tiptap-button-form .form-input {
    width: 180px;
    margin-right: 20px;
    color: black;
}

.tiptap-button-form .btn {
    width: 16px;
    height: 16px;
}


.tiptap-button::before {
    margin: 0;
    height: 16px;
    line-height: 0;
    position: relative;
}

.tiptap-button.is-bold::before {
    content: 'B';
}

.tiptap-button.is-italic::before {
    font-style: italic;
    content: 'I';
}

.tiptap-button.is-strike::before {
    text-decoration: line-through;
    content: 'S';
}

.tiptap-button.is-underline::before {
    text-decoration: underline;
    content: 'U';
}

.tiptap-button.is-code::before {
    content: '<>';
}




</style>

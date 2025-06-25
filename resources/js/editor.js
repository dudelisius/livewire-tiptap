import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Code from '@tiptap/extension-code';
import Highlight from '@tiptap/extension-highlight';
import Link from '@tiptap/extension-link';
import Underline from '@tiptap/extension-underline';

document.addEventListener('alpine:init', () => {
    Alpine.data('livewireTiptap', (content, livewireComponent, extensionConfig) => {
        let editor

        return {
            content: content,
            updatedAt: Date.now(),

            init() {
                const _this = this

                editor = new Editor({
                    element: this.$refs.livewireTiptapEditor,
                    content: this.content,
                    extensions: [
                        StarterKit.configure({ code: false }),
                        Code,
                        Highlight,
                        Link.configure(extensionConfig.link),
                        Underline
                    ],
                    onCreate({ editor }) {
                        _this.updatedAt = Date.now()
                    },
                    onUpdate({ editor }) {
                        _this.content = editor.getHTML()
                        _this.updatedAt = Date.now()
                    },
                    onSelectionUpdate({ editor }) {
                        _this.updatedAt = Date.now()
                    },
                    editorProps: {
                        attributes: {
                            class: 'focus:outline-none',
                        },
                    }
                })
            },
            isLoaded() {
                return editor
            },
            isActive(type, opts = {}) {
                return editor.isActive(type, opts)
            },
            toggleHeading(opts) {
                editor.chain().focus().toggleHeading(opts).run();
            },
            toggleBold() {
                editor.chain().focus().toggleBold().run()
            },
            toggleCode() {
                editor.chain().focus().toggleCode().run();
            },
            toggleHighlight() {
                editor.chain().focus().toggleHighlight().run()
            },
            toggleItalic() {
                editor.chain().focus().toggleItalic().run();
            },
            setLink() {
                const previousUrl = editor.getAttributes('link').href
                const url = window.prompt('URL', previousUrl)

                if (url === null) return

                if (url === '') {
                    editor.chain().focus().extendMarkRange('link').unsetLink().run()
                    return
                }

                editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run()
            },
            unsetLink() {
                editor.chain().focus().unsetLink().run();
            },
            toggleUnderline() {
                editor.chain().focus().toggleUnderline().run();
            },
            setTextAlign(align) {
                editor.chain().focus().setTextAlign(align).run()
            },
            undo() {
                editor.chain().focus().undo().run();
            },
            redo() {
                editor.chain().focus().redo().run();
            },
        }
    })
})

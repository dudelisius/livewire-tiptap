import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Subscript from '@tiptap/extension-subscript';
import Superscript from '@tiptap/extension-superscript';
import Highlight from '@tiptap/extension-highlight';
import Link from '@tiptap/extension-link';
import Underline from '@tiptap/extension-underline';

document.addEventListener('alpine:init', () => {
    Alpine.data('livewireTiptap', (content, livewireComponent, extensionConfig) => {
        let editor

        return {
            content: content,
            editor: editor,
            updatedAt: Date.now(),

            init() {
                const _this = this

                editor = new Editor({
                    element: this.$refs.livewireTiptapEditor,
                    content: this.content,
                    extensions: [
                        StarterKit,
                        Subscript,
                        Superscript,
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
            setParagraph() {
                editor.chain().focus().setParagraph().run()
            },
            toggleHeading(opts) {
                editor.chain().focus().toggleHeading(opts).run();
            },
            toggleBold() {
                editor.chain().focus().toggleBold().run()
            },
            toggleItalic() {
                editor.chain().focus().toggleItalic().run()
            },
            toggleStrike() {
                editor.chain().focus().toggleStrike().run()
            },
            toggleUnderline() {
                editor.chain().focus().toggleUnderline().run()
            },
            toggleBulletList() {
                console.log('toggle bullet list')
                editor.chain().focus().toggleBulletList().run();
            },
            toggleOrderedList() {
                console.log('toggle ordered list')
                editor.chain().focus().toggleOrderedList().run();
            },
            toggleSubscript() {
                editor.chain().focus().toggleSubscript().run();
            },
            toggleSuperscript() {
                editor.chain().focus().toggleSuperscript().run();
            },
            toggleCode() {
                editor.chain().focus().toggleCode().run();
            },
            toggleHighlight() {
                editor.chain().focus().toggleHighlight().run()
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

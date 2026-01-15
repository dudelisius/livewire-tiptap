
import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Subscript from '@tiptap/extension-subscript';
import Superscript from '@tiptap/extension-superscript';
import Highlight from '@tiptap/extension-highlight';
import Link from '@tiptap/extension-link';
import Underline from '@tiptap/extension-underline';
import Emoji from '@tiptap/extension-emoji';
import TextAlign from '@tiptap/extension-text-align'
import { Placeholder } from '@tiptap/extensions'

// import Table from '@tiptap/extension-table'
// import TableCell from '@tiptap/extension-table-cell'
// import TableHeader from '@tiptap/extension-table-header'
// import TableRow from '@tiptap/extension-table-row'
// import BubbleMenu from '@tiptap/extension-bubble-menu'

document.addEventListener('alpine:init', () => {
    Alpine.data('livewireTiptap', (content, b64) => {
        let editor

        return {
            content: content,
            editor: editor,
            updatedAt: Date.now(),
            _updatingFromEditor: false,
            _updatingFromModel: false,

            init() {
                const _this = this
                const decoded = atob(b64);
                const extensionConfig = Function('return (' + decoded + ')')();

                console.debug('livewire-tiptap config', extensionConfig, extensionConfig.link, extensionConfig.placeholder);

                editor = new Editor({
                    element: this.$refs.livewireTiptapEditor,
                    content: this.content,
                    extensions: [
                        StarterKit,
                        Subscript,
                        Superscript,
                        Highlight,
                        Underline,
                        Link.configure(extensionConfig.link),
                        Emoji.configure(extensionConfig.emoji),
                        TextAlign.configure(extensionConfig.textAlign),
                        Placeholder.configure(extensionConfig.placeholder),
                    ],
                    onCreate({ editor }) {
                        _this.updatedAt = Date.now()
                    },
                    onUpdate({ editor }) {
                        _this._updatingFromEditor = true

                        _this.content = editor.getHTML()
                        _this.updatedAt = Date.now()

                        queueMicrotask(() => {
                            _this._updatingFromEditor = false
                        })
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

                // Keep editor in sync when the Livewire model changes externally
                // (e.g. another editor on the page updates the same model).
                this.$watch('content', (value) => {
                    if (!editor) return
                    if (this._updatingFromEditor) return

                    const next = value ?? ''
                    const current = editor.getHTML()

                    if (next === current) return

                    this._updatingFromModel = true
                    editor.commands.setContent(next, false)
                    this.updatedAt = Date.now()

                    queueMicrotask(() => {
                        this._updatingFromModel = false
                    })
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
            setHardBreak() {
                editor.chain().focus().setHardBreak().run();
            },
            setHorizontalRule() {
                editor.chain().focus().setHorizontalRule().run();
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
                editor.chain().focus().toggleBulletList().run();
            },
            toggleOrderedList() {
                editor.chain().focus().toggleOrderedList().run();
            },
            toggleSubscript() {
                editor.chain().focus().toggleSubscript().run();
            },
            toggleSuperscript() {
                editor.chain().focus().toggleSuperscript().run();
            },
            toggleBlockquote() {
                editor.chain().focus().toggleBlockquote().run();
            },
            toggleHighlight() {
                editor.chain().focus().toggleHighlight().run()
            },
            toggleCode() {
                editor.chain().focus().toggleCode().run();
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

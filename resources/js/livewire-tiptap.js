import tippy from 'tippy.js';
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

function safeParseJsObjectLiteral(source) {
    try {
        return Function(`"use strict"; return (${source});`)()
    } catch (e) {
        console.error('[livewire-tiptap] Failed to parse extension config.', e)
        return {}
    }
}

function registerLivewireTiptap(Alpine) {
    Alpine.data('livewireTiptap', (content, b64) => {
        let editor

        return {
            content: content,
            editor: editor,
            updatedAt: Date.now(),
            _updatingFromEditor: false,
            _updatingFromModel: false,

            init() {
                const decoded = atob(b64)
                const extensionConfig = safeParseJsObjectLiteral(decoded)

                editor = new Editor({
                    element: this.$refs.livewireTiptapEditor,
                    content: this.content ?? '',
                    extensions: [
                        StarterKit,
                        Subscript,
                        Superscript,
                        Highlight,
                        Underline,
                        Link.configure(extensionConfig.link ?? {}),
                        Emoji.configure(extensionConfig.emoji ?? {}),
                        TextAlign.configure(extensionConfig.textAlign ?? {}),
                        Placeholder.configure({
                            'placeholder': this.$refs.livewireTiptapEditor.getAttribute('data-placeholder'),
                            ...extensionConfig.placeholder ?? {}
                        }),
                    ],
                    onCreate: () => {
                        this.updatedAt = Date.now()
                    },
                    onUpdate: ({ editor }) => {
                        this._updatingFromEditor = true

                        const html = editor.getHTML()
                        if (this.content !== html) {
                            this.content = html
                        }

                        this.updatedAt = Date.now()

                        queueMicrotask(() => {
                            this._updatingFromEditor = false
                        })
                    },
                    onSelectionUpdate: () => {
                        this.updatedAt = Date.now()
                    },
                    editorProps: {
                        attributes: {
                            class: 'focus:outline-none',
                        },
                    }
                })

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
}

function ensureRegistered() {
    if (window.Alpine && !window.__livewireTiptapRegistered) {
        window.__livewireTiptapRegistered = true
        registerLivewireTiptap(window.Alpine)
    }
}

function livewireEditorTooltip() {
    Alpine.magic('tooltip', el => message => {
        let instance = tippy(el, { content: message, trigger: 'manual' })

        instance.show()

        setTimeout(() => {
            instance.hide()
            setTimeout(() => instance.destroy(), 150)
        }, 2000)
    })

    Alpine.directive('tooltip', (el, { expression }) => {
        tippy(el, { content: expression, theme: 'livewire-tiptap-toolbar-button-tooltip' })
    })
}

ensureRegistered()

function alpineInit() {
    ensureRegistered()
    livewireEditorTooltip();
}

document.addEventListener('alpine:init', alpineInit)

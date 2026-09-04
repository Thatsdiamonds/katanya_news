import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';

document.addEventListener('DOMContentLoaded', () => {
    const editorElement = document.querySelector('#tiptap-editor');
    const hiddenInput = document.querySelector('#content');
    
    if (editorElement && hiddenInput) {
        const editor = new Editor({
            element: editorElement,
            extensions: [
                StarterKit,
                Link.configure({
                    openOnClick: false,
                }),
            ],
            content: hiddenInput.value,
            onUpdate: ({ editor }) => {
                hiddenInput.value = editor.getHTML();
            },
            editorProps: {
                attributes: {
                    class: 'prose prose-sm sm:prose lg:prose-lg xl:prose-xl focus:outline-none min-h-[300px]',
                },
            },
        });

        // Expose editor to window if needed
        window.tiptapEditor = editor;

        // Toolbar buttons
        document.querySelectorAll('#tiptap-toolbar button[data-action]').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const action = button.getAttribute('data-action');
                
                switch(action) {
                    case 'bold': editor.chain().focus().toggleBold().run(); break;
                    case 'italic': editor.chain().focus().toggleItalic().run(); break;
                    case 'h2': editor.chain().focus().toggleHeading({ level: 2 }).run(); break;
                    case 'h3': editor.chain().focus().toggleHeading({ level: 3 }).run(); break;
                    case 'bulletList': editor.chain().focus().toggleBulletList().run(); break;
                    case 'orderedList': editor.chain().focus().toggleOrderedList().run(); break;
                    case 'blockquote': editor.chain().focus().toggleBlockquote().run(); break;
                    case 'undo': editor.chain().focus().undo().run(); break;
                    case 'redo': editor.chain().focus().redo().run(); break;
                }
            });
        });
    }
});

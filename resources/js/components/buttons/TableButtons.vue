<template>
    <div class="
        bg-primary
        p-1 leading-none text-xs"
    >
        <button
            v-for="button in buttons"
            :key="button.title"
            type="button"
            @click="button.command()"
            :disabled="button.disabledIf()"
            v-html="button.title"
            class="px-2 rounded-full py-px mx-1 my-1 text-black text-xs bg-white hover:bg-20"
            :class="{
                'cursor-not-allowed': button.disabledIf(),
                'opacity-50': button.disabledIf(),
            }"

        >
        </button>
    </div>
</template>

<script>


export default {
    data: function (){
        return {
            buttons: [
                {
                    command: () => this.editor.chain().focus().addRowBefore().run(),
                    disabledIf: () => !this.editor.can().addRowBefore(),
                    title: 'add row before',
                },
                {
                    command: () => this.editor.chain().focus().addRowAfter().run(),
                    disabledIf: () => !this.editor.can().addRowAfter(),
                    title: 'add row after',
                },
                {
                    command: () => this.editor.chain().focus().deleteRow().run(),
                    disabledIf: () => !this.editor.can().deleteRow(),
                    title: 'delete row',
                },
                {
                    command: () => this.editor.chain().focus().addColumnBefore().run(),
                    disabledIf: () => !this.editor.can().addColumnBefore(),
                    title: 'add col before',
                },
                {
                    command: () => this.editor.chain().focus().addColumnAfter().run(),
                    disabledIf: () => !this.editor.can().addColumnAfter(),
                    title: 'add col after',
                },
                {
                    command: () => this.editor.chain().focus().deleteColumn().run(),
                    disabledIf: () => !this.editor.can().deleteColumn(),
                    title: 'delete col',
                },
                {
                    command: () => this.editor.chain().focus().mergeCells().run(),
                    disabledIf: () => !this.editor.can().mergeCells(),
                    title: 'merge cells',
                },
                {
                    command: () => this.editor.chain().focus().splitCell().run(),
                    disabledIf: () => !this.editor.can().splitCell(),
                    title: 'split cell',
                },
                {
                    command: () => this.editor.chain().focus().toggleHeaderColumn().run(),
                    disabledIf: () => !this.editor.can().toggleHeaderColumn(),
                    title: 'header col',
                },
                {
                    command: () => this.editor.chain().focus().toggleHeaderRow().run(),
                    disabledIf: () => !this.editor.can().toggleHeaderRow(),
                    title: 'header row',
                },
                {
                    command: () => this.editor.chain().focus().toggleHeaderCell().run(),
                    disabledIf: () => !this.editor.can().toggleHeaderCell(),
                    title: 'header cell',
                },
                {
                    command: () => this.editor.chain().focus().deleteTable().run(),
                    disabledIf: () => !this.editor.can().deleteTable(),
                    title: 'delete table',
                },
                
                
            ]
        }
    },
    props: ['editor'],
}
</script>

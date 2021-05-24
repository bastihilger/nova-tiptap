<template>
    <span class="whitespace-nowrap">
        <button
            v-for="level in headingLevels"
            :key="'heading-button'+level"
            type="button"
            class="
                btn btn-default p-1 m-1
                leading-none text-xs
                min-w-8 mr-1 h-8
                tiptap-button
            "
            :class="{ 
                'btn-primary': editor ? editor.isActive('heading', { level: level }) : false,
                'bg-white hover:bg-20': editor ? !editor.isActive('heading', { level: level }) : true,
                'opacity-50 pointer-events-none': mode != 'editor',
            }"
            @click="editor.chain().focus().toggleHeading({ level: level }).run()"
        >
          H{{  level  }}
        </button>
    </span>
</template>

<script>

export default {
    props: ['headingLevels', 'editor', 'mode'],
}

</script>

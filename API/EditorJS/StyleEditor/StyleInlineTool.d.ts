import type { InlineTool, InlineToolConstructorOptions } from '@editorjs/editorjs';
declare class StyleInlineTool implements InlineTool {
    #private;
    static get isInline(): boolean;
    static get sanitize(): {
        'editorjs-style': {
            class: boolean;
            id: boolean;
            style: boolean;
        };
    };
    static get title(): string;
    static prepare(): void;
    constructor({ api }: InlineToolConstructorOptions);
    get shortcut(): string;
    checkState(): boolean;
    clear(): void;
    render(): HTMLButtonElement;
    renderActions(): HTMLElement;
    surround(range: Range): void;
}
export { StyleInlineTool };

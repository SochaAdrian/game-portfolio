import type {
    ColorSwatchPickerItemProps,
    ColorSwatchPickerProps,
} from 'react-aria-components';
import {
    ColorSwatchPickerItem,
    ColorSwatchPicker as ColorSwatchPickerPrimitive,
} from 'react-aria-components';
import {tv} from 'tailwind-variants';

import {ColorSwatch} from './color-swatch';
import {ctr, focusRing} from './primitive';

const ColorSwatchPicker = ({
                               children,
                               className,
                               layout = 'grid',
                               ...props
}: ColorSwatchPickerProps) => {
    return (
        <ColorSwatchPickerPrimitive
            layout={layout}
            {...props}
            className={ctr(className, 'flex gap-1')}
        >
            {children}
        </ColorSwatchPickerPrimitive>
    );
};

const itemStyles = tv({
    extend: focusRing,
    base: 'relative rounded disabled:opacity-50',
});

const SwatchPickerItem = (props: ColorSwatchPickerItemProps) => {
    return (
        <ColorSwatchPickerItem {...props} className={itemStyles}>
            {({isSelected}) => (
                <>
                    <ColorSwatch/>
                    {isSelected && (
                        <div
                            className="absolute left-0 top-0 h-full w-full rounded-[calc(var(--radius)-3.9px)] outline-none ring-1 ring-inset ring-fg/30 forced-color-adjust-none"/>
                    )}
                </>
            )}
        </ColorSwatchPickerItem>
    );
};

ColorSwatchPicker.Item = SwatchPickerItem;

export {ColorSwatchPicker};

import React from 'react';

import type {Placement} from '@react-types/overlays';
import {
    Button,
    ColorPicker as ColorPickerPrimitive,
    type ColorPickerProps as ColorPickerPrimitiveProps,
    Dialog,
} from 'react-aria-components';
import {tv} from 'tailwind-variants';

import {ColorArea} from './color-area';
import {ColorField} from './color-field';
import {ColorSlider} from './color-slider';
import {ColorSwatch} from './color-swatch';
import {Description} from './field';
import {Popover} from './popover';
import {focusButtonStyles} from './primitive';

const buttonStyles = tv({
    extend: focusButtonStyles,
    base: 'flex btn-trigger cursor-pointer disabled:cursor-default disabled:opacity-50 items-center rounded text-sm',
});

export interface ColorPickerProps extends ColorPickerPrimitiveProps {
    label?: string;
    children?: React.ReactNode;
    showArrow?: boolean;
    isDisabled?: boolean;
    placement?: Placement;
    description?: string;
}

const ColorPicker = ({
                         showArrow = false,
                         placement = 'bottom start',
                         label,
                         isDisabled,
                         children,
                         description,
                         ...props
}: ColorPickerProps) => {
    return (
        <div className="flex flex-col gap-y-2">
            <ColorPickerPrimitive {...props}>
                <Popover>
                    <Button isDisabled={isDisabled} className={buttonStyles}>
                        <ColorSwatch className="size-6"/>
                        {label && <span className="ml-2">{label}</span>}
                    </Button>
                    <Popover.Content
                        className="overflow-y-auto px-0 pb-3 pt-4 sm:min-w-min sm:max-w-56 sm:p-3 [&_[data-slot=color-area]]:w-full sm:[&_[data-slot=color-area]]:size-56 [&_[data-slot=color-slider]]:w-full"
                        showArrow={showArrow}
                        placement={placement}
                    >
                        <Dialog className="flex flex-col gap-2 focus:outline-none">
                            {children || (
                                <>
                                    <ColorArea
                                        colorSpace="hsb"
                                        xChannel="saturation"
                                        yChannel="brightness"
                                    />
                                    <ColorSlider
                                        showOutput={false}
                                        colorSpace="hsb"
                                        channel="hue"
                                    />
                                    <ColorField aria-label="Hex"/>
                                </>
                            )}
                        </Dialog>
                    </Popover.Content>
                </Popover>
            </ColorPickerPrimitive>
            {description && <Description>{description}</Description>}
        </div>
    );
};

export {ColorPicker};

import { type ClassValue, clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export const statTrakifyName = (itemNameInput: string, isStatTrak: boolean) => {
    const prefix = isStatTrak ? (itemNameInput.includes('★') ? '★ StatTrak™ ' : 'StatTrak™ ') : '';
    const itemName = isStatTrak ? itemNameInput.replace('★', '') : itemNameInput;
    return prefix + itemName;
};

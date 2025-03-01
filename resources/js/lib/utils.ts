import { IndexedDBItem, UnboxWithRelations } from '@/types';
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

export const gradeColors = {
    'Consumer Grade': '#b0c3d9',
    'Industrial Grade': '#5e98d9',
    'Mil-Spec Grade': '#4b69ff',
    Restricted: '#8847ff',
    Classified: '#d32ee6',
    Covert: '#eb4b4b',
    'Rare Special Item': '#ffd700',
};

export const dbUnboxToIndexedDBItem = (dbUnbox: UnboxWithRelations): IndexedDBItem => {
    return {
        id: dbUnbox.item.id,
        name: statTrakifyName(dbUnbox.item.name, dbUnbox.is_stat_trak),
        rarity: dbUnbox.item.rarity,
        phase: dbUnbox.item.phase,
    };
};

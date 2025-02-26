import { ItemGrade } from '@/types';
import { useAudio } from './providers/audio-provider';

const gradeColors = {
    'Consumer Grade': '#b0c3d9',
    'Industrial Grade': '#5e98d9',
    'Mil-Spec Grade': '#4b69ff',
    Restricted: '#8847ff',
    Classified: '#d32ee6',
    Covert: '#eb4b4b',
    'Rare Special Item': '#ffd700',
};

type Props = {
    itemName: string;
    skinName?: string;
    image?: string;
    grade?: ItemGrade;
    isSpecial?: boolean;
};

export default ({ itemName, skinName, image, grade = 'Mil-Spec Grade', isSpecial }: Props) => {
    const { itemHoverSound } = useAudio();

    return (
        <div className="group flex w-44 flex-col gap-1 transition-all" onMouseEnter={() => itemHoverSound.play()}>
            <div
                className={`flex h-32 w-44 items-center justify-center border-b-[6px] bg-gradient-to-b from-neutral-600 to-neutral-400 shadow-md transition-all group-hover:shadow-lg group-hover:drop-shadow-lg`}
                style={{
                    borderColor: gradeColors[grade] ?? gradeColors['Mil-Spec Grade'],
                }}
            >
                <img
                    className={`${isSpecial ? 'h-full w-full object-cover' : 'p-2'}`}
                    src={image ?? '/images/m4a4_howl.png'}
                    alt={`${itemName} image`}
                    draggable={false}
                />
            </div>

            <div className="flex flex-col px-px text-sm text-white">
                <span className="font-semibold tracking-wider">{itemName}</span>
                <span className="tracking-wide">{skinName}</span>
            </div>
        </div>
    );
};

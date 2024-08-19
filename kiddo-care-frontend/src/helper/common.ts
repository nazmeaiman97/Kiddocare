export const toLocaleStringHelper = (date: string, dateOnly: boolean = false) => {
    const convertDate = new Date(date);
    return dateOnly ? convertDate.toLocaleDateString() : convertDate.toLocaleString();
};